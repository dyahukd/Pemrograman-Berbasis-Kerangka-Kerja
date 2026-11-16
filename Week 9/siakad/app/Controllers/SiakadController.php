<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class SiakadController extends BaseController
{
    private $db;
    private string $year='2026/2027';
    private string $term='Ganjil';
    private const MAX_SKS=24;
    private const GRADES=['A','AB','B','BC','C','D','E'];
    private const WEIGHTS=['A'=>4,'AB'=>3.5,'B'=>3,'BC'=>2.5,'C'=>2,'D'=>1,'E'=>0];

    public function __construct(){ $this->db=db_connect(); }

    private function page(string $title,string $view,array $data=[]): string
    {
        return view('layouts/main',[
            'title'=>$title,'view'=>$view,'data'=>$data,
            'nama'=>session()->get('nama'),'role'=>session()->get('role')
        ]);
    }

    private function profile(string $table): array
    {
        $row=$this->db->table($table)->where('user_id',session()->get('user_id'))->get()->getRowArray();
        if(!$row) throw PageNotFoundException::forPageNotFound('Profil tidak ditemukan.');
        return $row;
    }

    public function dashboard()
    {
        return match(session()->get('role')){
            'admin'=>redirect()->to('/admin'),
            'dosen'=>redirect()->to('/dosen'),
            default=>redirect()->to('/mahasiswa')
        };
    }

    public function adminDashboard()
    {
        $counts=[
            'mahasiswa'=>$this->db->table('mahasiswa')->countAllResults(),
            'dosen'=>$this->db->table('dosen')->countAllResults(),
            'matakuliah'=>$this->db->table('matakuliah')->countAllResults(),
            'krs'=>$this->db->table('krs')->where(['tahun_ajaran'=>$this->year,'semester'=>$this->term])->countAllResults()
        ];
        return $this->page('Dashboard Admin','pages/admin_dashboard',['counts'=>$counts]);
    }

    private function resourceConfig(string $resource): array
    {
        $map=[
            'mahasiswa'=>['table'=>'mahasiswa','title'=>'Mahasiswa','search'=>'nim','joins'=>true],
            'dosen'=>['table'=>'dosen','title'=>'Dosen','search'=>'nidn','joins'=>true],
            'matakuliah'=>['table'=>'matakuliah','title'=>'Mata Kuliah','search'=>'kode','joins'=>true],
        ];
        if(!isset($map[$resource])) throw PageNotFoundException::forPageNotFound();
        return $map[$resource];
    }

    public function resource($resource=null)
    {
        // Route parameter fallback for resource listing.
        $resource=$this->request->getUri()->getSegment(2);
        $cfg=$this->resourceConfig($resource);
        $q=trim((string)$this->request->getGet('q'));
        $builder=$this->db->table($cfg['table'].' t');
        if($resource==='mahasiswa') $builder->select('t.*,u.nama,u.username,d.nidn,du.nama AS nama_wali')->join('users u','u.id=t.user_id')->join('dosen d','d.id=t.dosen_wali_id','left')->join('users du','du.id=d.user_id','left');
        if($resource==='dosen') $builder->select('t.*,u.nama,u.username')->join('users u','u.id=t.user_id');
        if($resource==='matakuliah') $builder->select('t.*,u.nama AS nama_dosen')->join('dosen d','d.id=t.dosen_id','left')->join('users u','u.id=d.user_id','left');
        if($q!==''){
            if($resource==='mahasiswa') $builder->groupStart()->like('t.nim',$q)->orLike('u.nama',$q)->groupEnd();
            elseif($resource==='dosen') $builder->groupStart()->like('t.nidn',$q)->orLike('u.nama',$q)->groupEnd();
            else $builder->groupStart()->like('t.kode',$q)->orLike('t.nama',$q)->groupEnd();
        }
        $rows=$builder->orderBy($resource==='matakuliah'?'t.kode':($resource==='mahasiswa'?'t.nim':'t.nidn'))
            ->get(10, max(0,((int)$this->request->getGet('page')-1)*10))->getResultArray();
        $total=$this->db->table($cfg['table'])->countAllResults();
        return $this->page('Data '.$cfg['title'],'pages/admin_resource',[
            'resource'=>$resource,'config'=>$cfg,'rows'=>$rows,'q'=>$q,
            'pageNo'=>max(1,(int)$this->request->getGet('page')),'total'=>$total
        ]);
    }

    public function resourceForm($resource)
    {
        $this->resourceConfig($resource);
        $data=['resource'=>$resource,'row'=>null,'lecturers'=>$this->lecturers()];
        return $this->page('Tambah '.ucfirst($resource),'pages/admin_form',$data);
    }

    public function resourceEdit($id,$resource)
    {
        $this->resourceConfig($resource);
        $row=$this->db->table($resource)->where('id',$id)->get()->getRowArray();
        if(!$row) throw PageNotFoundException::forPageNotFound();
        if(in_array($resource,['mahasiswa','dosen'])) {
            $profile=$row;
            $user=$this->db->table('users')->where('id',$row['user_id'])->get()->getRowArray();
            $row=array_merge($profile,$user??[]);
        }
        return $this->page('Edit '.ucfirst($resource),'pages/admin_form',[
            'resource'=>$resource,'row'=>$row,'lecturers'=>$this->lecturers()
        ]);
    }

    private function lecturers(): array
    {
        return $this->db->table('dosen d')->select('d.id,u.nama,d.nidn')
            ->join('users u','u.id=d.user_id')->orderBy('u.nama')->get()->getResultArray();
    }

    private function validateResource(string $resource,array $p,?int $id=null): ?string
    {
        if($resource==='mahasiswa'){
            if(strlen($p['nim']??'')<8 || trim($p['nama']??'')==='' || trim($p['angkatan']??'')==='') return 'NIM minimal 8 karakter, nama dan angkatan wajib diisi.';
            $exists=$this->db->table('mahasiswa')->where('nim',$p['nim'])->where('id !=',$id??0)->countAllResults();
        } elseif($resource==='dosen'){
            if(strlen($p['nidn']??'')<8 || trim($p['nama']??'')==='') return 'NIDN minimal 8 karakter dan nama wajib diisi.';
            $exists=$this->db->table('dosen')->where('nidn',$p['nidn'])->where('id !=',$id??0)->countAllResults();
        } else {
            if(trim($p['kode']??'')==='' || trim($p['nama']??'')==='' || (int)($p['sks']??0)<1 || (int)$p['sks']>6 || (int)($p['semester']??0)<1) return 'Kode, nama, semester dan SKS (1–6) wajib valid.';
            $exists=$this->db->table('matakuliah')->where('kode',$p['kode'])->where('id !=',$id??0)->countAllResults();
        }
        return $exists?'Nomor atau kode tersebut sudah digunakan.':null;
    }

    private function uploadPhoto(bool $required=false): array
    {
        $file=$this->request->getFile('foto');
        if(!$file || $file->getError()===UPLOAD_ERR_NO_FILE){
            return $required?['error'=>'Foto mahasiswa wajib diunggah.']:['name'=>null];
        }
        if(!$file->isValid() || !in_array($file->getMimeType(),['image/jpeg','image/png','image/webp'],true) || $file->getSizeByUnit('kb')>1024){
            return ['error'=>'Foto harus JPG, PNG, atau WEBP dengan ukuran maksimal 1 MB.'];
        }
        $dir=FCPATH.'uploads/foto/';
        if(!is_dir($dir)) mkdir($dir,0775,true);
        $name=$file->getRandomName();
        $file->move($dir,$name);
        return ['name'=>$name];
    }

    public function resourceCreate($resource)
    {
        $p=$this->request->getPost();
        if($err=$this->validateResource($resource,$p)) return redirect()->back()->withInput()->with('error',$err);
        $photo=null;
        if($resource==='mahasiswa'){
            $up=$this->uploadPhoto(true); if(isset($up['error'])) return redirect()->back()->withInput()->with('error',$up['error']); $photo=$up['name'];
        }
        $this->db->transBegin();
        try{
            if($resource==='mahasiswa'){
                $this->db->table('users')->insert(['username'=>$p['nim'],'password'=>password_hash($p['nim'],PASSWORD_DEFAULT),'nama'=>$p['nama'],'role'=>'mahasiswa']);
                $uid=$this->db->insertID();
                $this->db->table('mahasiswa')->insert(['user_id'=>$uid,'nim'=>$p['nim'],'angkatan'=>$p['angkatan'],'dosen_wali_id'=>$p['dosen_wali_id']?:null,'foto'=>$photo]);
            }elseif($resource==='dosen'){
                $this->db->table('users')->insert(['username'=>$p['nidn'],'password'=>password_hash($p['nidn'],PASSWORD_DEFAULT),'nama'=>$p['nama'],'role'=>'dosen']);
                $this->db->table('dosen')->insert(['user_id'=>$this->db->insertID(),'nidn'=>$p['nidn'],'email'=>$p['email']??null]);
            }else{
                $this->db->table('matakuliah')->insert(['kode'=>$p['kode'],'nama'=>$p['nama'],'sks'=>$p['sks'],'semester'=>$p['semester'],'dosen_id'=>$p['dosen_id']?:null,'kuota'=>$p['kuota']?:40]);
            }
            $this->db->transCommit();
        }catch(\Throwable $e){$this->db->transRollback();if($photo) @unlink(FCPATH.'uploads/foto/'.$photo);return redirect()->back()->withInput()->with('error','Data gagal disimpan: '.$e->getMessage());}
        return redirect()->to('/admin/'.$resource)->with('success','Data berhasil ditambahkan. Akun dibuat dengan password awal NIM/NIDN.');
    }

    public function resourceUpdate($id,$resource)
    {
        $p=$this->request->getPost();
        $old=$this->db->table($resource)->where('id',$id)->get()->getRowArray();
        if(!$old) throw PageNotFoundException::forPageNotFound();
        if($err=$this->validateResource($resource,$p,(int)$id)) return redirect()->back()->withInput()->with('error',$err);
        $newPhoto=null;
        if($resource==='mahasiswa'){
            $up=$this->uploadPhoto(false);if(isset($up['error']))return redirect()->back()->withInput()->with('error',$up['error']);$newPhoto=$up['name'];
        }
        $this->db->transBegin();
        try{
            if($resource==='mahasiswa'){
                $this->db->table('users')->where('id',$old['user_id'])->update(['username'=>$p['nim'],'nama'=>$p['nama']]);
                $data=['nim'=>$p['nim'],'angkatan'=>$p['angkatan'],'dosen_wali_id'=>$p['dosen_wali_id']?:null];
                if($newPhoto)$data['foto']=$newPhoto;
                $this->db->table('mahasiswa')->where('id',$id)->update($data);
            }elseif($resource==='dosen'){
                $this->db->table('users')->where('id',$old['user_id'])->update(['username'=>$p['nidn'],'nama'=>$p['nama']]);
                $this->db->table('dosen')->where('id',$id)->update(['nidn'=>$p['nidn'],'email'=>$p['email']??null]);
            }else{
                $this->db->table('matakuliah')->where('id',$id)->update(['kode'=>$p['kode'],'nama'=>$p['nama'],'sks'=>$p['sks'],'semester'=>$p['semester'],'dosen_id'=>$p['dosen_id']?:null,'kuota'=>$p['kuota']?:40]);
            }
            $this->db->transCommit();
        }catch(\Throwable $e){$this->db->transRollback();if($newPhoto)@unlink(FCPATH.'uploads/foto/'.$newPhoto);return redirect()->back()->withInput()->with('error','Perubahan gagal: '.$e->getMessage());}
        if($newPhoto && !empty($old['foto'])) @unlink(FCPATH.'uploads/foto/'.$old['foto']);
        return redirect()->to('/admin/'.$resource)->with('success','Data berhasil diperbarui.');
    }

    public function resourceDelete($id,$resource)
    {
        $row=$this->db->table($resource)->where('id',$id)->get()->getRowArray();
        if(!$row)throw PageNotFoundException::forPageNotFound();
        try{
            if(in_array($resource,['mahasiswa','dosen'])) $this->db->table('users')->where('id',$row['user_id'])->delete();
            else $this->db->table('matakuliah')->where('id',$id)->delete();
        }catch(\Throwable $e){return redirect()->back()->with('error','Data tidak dapat dihapus karena masih memiliki relasi akademik.');}
        if($resource==='mahasiswa' && !empty($row['foto'])) @unlink(FCPATH.'uploads/foto/'.$row['foto']);
        return redirect()->to('/admin/'.$resource)->with('success','Data berhasil dihapus.');
    }

    public function resetAccount($type,$id)
    {
        if(!in_array($type,['mahasiswa','dosen'],true))throw PageNotFoundException::forPageNotFound();
        $r=$this->db->table($type)->where('id',$id)->get()->getRowArray();
        if(!$r)throw PageNotFoundException::forPageNotFound();
        $username=$type==='mahasiswa'?$r['nim']:$r['nidn'];
        $this->db->table('users')->where('id',$r['user_id'])->update(['password'=>password_hash($username,PASSWORD_DEFAULT)]);
        return redirect()->back()->with('success','Password akun direset ke NIM/NIDN.');
    }

    public function studentDashboard()
    {
        $m=$this->profile('mahasiswa');
        $count=$this->db->table('krs')->where(['mahasiswa_id'=>$m['id'],'tahun_ajaran'=>$this->year,'semester'=>$this->term])->countAllResults();
        return $this->page('Dashboard Mahasiswa','pages/student_dashboard',['profile'=>$m,'count'=>$count]);
    }

    public function krs()
    {
        $m=$this->profile('mahasiswa');
        $chosen=$this->db->table('krs k')->select('k.*,mk.kode,mk.nama,mk.sks,u.nama AS dosen')
            ->join('matakuliah mk','mk.id=k.matakuliah_id')->join('dosen d','d.id=mk.dosen_id','left')->join('users u','u.id=d.user_id','left')
            ->where(['k.mahasiswa_id'=>$m['id'],'k.tahun_ajaran'=>$this->year,'k.semester'=>$this->term])->get()->getResultArray();
        $ids=array_column($chosen,'matakuliah_id');
        $builder=$this->db->table('matakuliah mk')->select('mk.*,u.nama AS dosen')
            ->join('dosen d','d.id=mk.dosen_id','left')->join('users u','u.id=d.user_id','left');
        if($ids)$builder->whereNotIn('mk.id',$ids);
        $available=$builder->orderBy('mk.kode')->get()->getResultArray();
        $sks=array_sum(array_column($chosen,'sks'));
        return $this->page('Pengisian KRS','pages/student_krs',['chosen'=>$chosen,'available'=>$available,'totalSks'=>$sks]);
    }

    public function takeCourse()
    {
        $m=$this->profile('mahasiswa');$id=(int)$this->request->getPost('matakuliah_id');
        $course=$this->db->table('matakuliah')->where('id',$id)->get()->getRowArray();
        if(!$course)return redirect()->back()->with('error','Mata kuliah tidak ditemukan.');
        $existing=$this->db->table('krs')->where(['mahasiswa_id'=>$m['id'],'matakuliah_id'=>$id,'tahun_ajaran'=>$this->year,'semester'=>$this->term])->countAllResults();
        if($existing)return redirect()->back()->with('error','Mata kuliah sudah ada di KRS.');
        $count=$this->db->table('krs')->where(['matakuliah_id'=>$id,'tahun_ajaran'=>$this->year,'semester'=>$this->term])->countAllResults();
        if($count >= $course['kuota'])return redirect()->back()->with('error','Kuota kelas sudah penuh.');
        $total=(int)$this->db->table('krs k')->selectSum('mk.sks','total')->join('matakuliah mk','mk.id=k.matakuliah_id')
            ->where(['k.mahasiswa_id'=>$m['id'],'k.tahun_ajaran'=>$this->year,'k.semester'=>$this->term])->get()->getRow()->total;
        if($total+(int)$course['sks']>self::MAX_SKS)return redirect()->back()->with('error','Total SKS melebihi batas 24 SKS.');
        $this->db->table('krs')->insert(['mahasiswa_id'=>$m['id'],'matakuliah_id'=>$id,'tahun_ajaran'=>$this->year,'semester'=>$this->term]);
        return redirect()->to('/mahasiswa/krs')->with('success','Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function dropCourse($id)
    {
        $m=$this->profile('mahasiswa');
        $this->db->table('krs')->where(['id'=>$id,'mahasiswa_id'=>$m['id'],'tahun_ajaran'=>$this->year,'semester'=>$this->term])
            ->where('nilai',null)->delete();
        if($this->db->affectedRows())return redirect()->back()->with('success','Mata kuliah berhasil dibatalkan.');
        return redirect()->back()->with('error','KRS tidak ditemukan, bukan milik Anda, semester berbeda, atau sudah dinilai.');
    }

    private function studentGrades(): array
    {
        $m=$this->profile('mahasiswa');
        return $this->db->table('krs k')->select('k.*,mk.kode,mk.nama,mk.sks')
            ->join('matakuliah mk','mk.id=k.matakuliah_id')->where('k.mahasiswa_id',$m['id'])->where('k.nilai IS NOT NULL',null,false)
            ->orderBy('k.tahun_ajaran')->orderBy('k.semester')->orderBy('mk.kode')->get()->getResultArray();
    }

    private function gpa(array $rows): string
    {
        $sks=0;$points=0;
        foreach($rows as $r)if($r['nilai']!==null && isset(self::WEIGHTS[$r['nilai']])){$sks+=(int)$r['sks'];$points+=(int)$r['sks']*self::WEIGHTS[$r['nilai']];}
        return $sks?number_format($points/$sks,2):'-';
    }

    public function khs()
    {
        $rows=$this->studentGrades();$groups=[];
        foreach($rows as $r)$groups[$r['tahun_ajaran'].' '.$r['semester']][]=$r;
        $cards=[];
        foreach($groups as $period=>$items)$cards[]=['period'=>$period,'rows'=>$items,'ip'=>$this->gpa($items)];
        return $this->page('Kartu Hasil Studi','pages/student_khs',['cards'=>$cards,'ipk'=>$this->gpa($rows)]);
    }

    public function transcript()
    {
        $rows=$this->studentGrades();$best=[];
        foreach($rows as $r){
            $key=$r['matakuliah_id'];
            if(!isset($best[$key]) || (self::WEIGHTS[$r['nilai']??'']??-1)>(self::WEIGHTS[$best[$key]['nilai']??'']??-1))$best[$key]=$r;
        }
        return $this->page('Transkrip Akademik','pages/student_transcript',['rows'=>array_values($best),'ipk'=>$this->gpa(array_values($best))]);
    }

    public function printTranscript()
    {
        $rows=$this->studentGrades();$best=[];
        foreach($rows as $r){$key=$r['matakuliah_id'];if(!isset($best[$key])||(self::WEIGHTS[$r['nilai']??'']??-1)>(self::WEIGHTS[$best[$key]['nilai']??'']??-1))$best[$key]=$r;}
        return view('pages/print_transcript',['rows'=>array_values($best),'ipk'=>$this->gpa(array_values($best)),'nama'=>session()->get('nama'),'nim'=>$this->profile('mahasiswa')['nim']]);
    }

    public function printKrs()
    {
        $m=$this->profile('mahasiswa');
        $rows=$this->db->table('krs k')->select('mk.kode,mk.nama,mk.sks,u.nama AS dosen')
            ->join('matakuliah mk','mk.id=k.matakuliah_id')->join('dosen d','d.id=mk.dosen_id','left')->join('users u','u.id=d.user_id','left')
            ->where(['k.mahasiswa_id'=>$m['id'],'k.tahun_ajaran'=>$this->year,'k.semester'=>$this->term])->get()->getResultArray();
        return view('pages/print_krs',['rows'=>$rows,'nama'=>session()->get('nama'),'nim'=>$m['nim'],'wali'=>$this->db->table('dosen d')->select('u.nama')->join('users u','u.id=d.user_id')->where('d.id',$m['dosen_wali_id'])->get()->getRow('nama')]);
    }

    public function lecturerDashboard()
    {
        $d=$this->profile('dosen');
        $courses=$this->db->table('matakuliah')->where('dosen_id',$d['id'])->countAllResults();
        $adv=$this->db->table('mahasiswa')->where('dosen_wali_id',$d['id'])->countAllResults();
        return $this->page('Dashboard Dosen','pages/lecturer_dashboard',['courses'=>$courses,'advisees'=>$adv]);
    }

    public function advisees()
    {
        $d=$this->profile('dosen');
        $rows=$this->db->table('mahasiswa m')->select('m.*,u.nama,u.username')->join('users u','u.id=m.user_id')
            ->where('m.dosen_wali_id',$d['id'])->orderBy('m.nim')->get()->getResultArray();
        return $this->page('Mahasiswa Perwalian','pages/lecturer_advisees',['rows'=>$rows]);
    }

    public function lecturerCourses()
    {
        $d=$this->profile('dosen');
        $rows=$this->db->table('matakuliah')->where('dosen_id',$d['id'])->orderBy('kode')->get()->getResultArray();
        return $this->page('Mata Kuliah Diampu','pages/lecturer_courses',['rows'=>$rows]);
    }

    public function gradeForm($id)
    {
        $d=$this->profile('dosen');
        $course=$this->db->table('matakuliah')->where(['id'=>$id,'dosen_id'=>$d['id']])->get()->getRowArray();
        if(!$course)throw PageNotFoundException::forPageNotFound('Mata kuliah bukan tanggung jawab dosen ini.');
        $students=$this->db->table('krs k')->select('k.id AS krs_id,k.nilai,m.nim,u.nama')
            ->join('mahasiswa m','m.id=k.mahasiswa_id')->join('users u','u.id=m.user_id')
            ->where(['k.matakuliah_id'=>$id,'k.tahun_ajaran'=>$this->year,'k.semester'=>$this->term])->orderBy('m.nim')->get()->getResultArray();
        return $this->page('Input Nilai','pages/lecturer_grades',['course'=>$course,'students'=>$students]);
    }

    public function saveGrades($id)
    {
        $d=$this->profile('dosen');
        $course=$this->db->table('matakuliah')->where(['id'=>$id,'dosen_id'=>$d['id']])->get()->getRowArray();
        if(!$course)throw PageNotFoundException::forPageNotFound();
        $grades=$this->request->getPost('nilai')??[];
        $participants=$this->db->table('krs')->select('id')->where(['matakuliah_id'=>$id,'tahun_ajaran'=>$this->year,'semester'=>$this->term])->get()->getResultArray();
        $allowed=array_map('intval',array_column($participants,'id'));
        foreach($grades as $krsId=>$grade){
            if(!in_array((int)$krsId,$allowed,true)||!in_array($grade,self::GRADES,true))return redirect()->back()->with('error','Terdapat nilai atau peserta yang tidak valid. Tidak ada nilai yang disimpan.');
        }
        $this->db->transBegin();
        foreach($grades as $krsId=>$grade)$this->db->table('krs')->where('id',(int)$krsId)->where('matakuliah_id',$id)->update(['nilai'=>$grade]);
        $this->db->transComplete();
        return redirect()->to('/dosen/nilai/'.$id)->with('success','Seluruh nilai berhasil disimpan.');
    }

    public function password()
    {
        return $this->page('Ganti Password','pages/password');
    }

    public function updatePassword()
    {
        $old=(string)$this->request->getPost('old_password');
        $new=(string)$this->request->getPost('new_password');
        $confirm=(string)$this->request->getPost('confirm_password');
        $u=$this->db->table('users')->where('id',session()->get('user_id'))->get()->getRowArray();
        if(!$u||!password_verify($old,$u['password']))return redirect()->back()->with('error','Password lama tidak sesuai.');
        if(strlen($new)<8)return redirect()->back()->with('error','Password baru minimal 8 karakter.');
        if($new!==$confirm)return redirect()->back()->with('error','Konfirmasi password tidak sama.');
        $this->db->table('users')->where('id',$u['id'])->update(['password'=>password_hash($new,PASSWORD_DEFAULT)]);
        return redirect()->to('/password')->with('success','Password berhasil diperbarui.');
    }
}
