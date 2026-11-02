using System;
using System.Collections.Generic;

namespace DataMahasiswa
{
    class Mahasiswa
    {
        public string NRP { get; set; }
        public string Nama { get; set; }
        public string Prodi { get; set; }
        public double IPK { get; set; }

        public Mahasiswa(string nrp, string nama, string prodi, double ipk)
        {
            NRP = nrp;
            Nama = nama;
            Prodi = prodi;
            IPK = ipk;
        }
    }

    class Program
    {
        static List<Mahasiswa> daftarMahasiswa = new List<Mahasiswa>();

        static void Main(string[] args)
        {
            int pilihan;

            do
            {
                TampilkanMenu();

                Console.Write("Pilihan: ");
                string input = Console.ReadLine();

                if (!int.TryParse(input, out pilihan))
                {
                    pilihan = 0;
                }

                Console.WriteLine();

                switch (pilihan)
                {
                    case 1:
                        TambahMahasiswa();
                        break;
                    case 2:
                        TampilkanMahasiswa();
                        break;
                    case 3:
                        CariMahasiswa();
                        break;
                    case 4:
                        HapusMahasiswa();
                        break;
                    case 5:
                        Pesan("Terima kasih telah menggunakan program.", ConsoleColor.Green);
                        break;
                    default:
                        Pesan("Pilihan tidak tersedia!", ConsoleColor.Red);
                        break;
                }

                if (pilihan != 5)
                {
                    Console.WriteLine();
                    Console.Write("Tekan ENTER untuk melanjutkan...");
                    Console.ReadLine();
                }

            } while (pilihan != 5);
        }

        static void TampilkanMenu()
        {
            Console.Clear();

            Console.ForegroundColor = ConsoleColor.Cyan;
            Console.WriteLine("========================================");
            Console.WriteLine("       SISTEM DATA MAHASISWA");
            Console.WriteLine("========================================");
            Console.ResetColor();

            Console.WriteLine($"Total Mahasiswa : {daftarMahasiswa.Count}");

            if (daftarMahasiswa.Count > 0)
            {
                double total = 0;
                double tertinggi = daftarMahasiswa[0].IPK;

                foreach (Mahasiswa m in daftarMahasiswa)
                {
                    total += m.IPK;
                    if (m.IPK > tertinggi) tertinggi = m.IPK;
                }

                double rata = total / daftarMahasiswa.Count;
                Console.WriteLine($"Rata-rata IPK   : {rata:F2}");
                Console.WriteLine($"IPK Tertinggi   : {tertinggi:F2}");
            }

            Console.WriteLine("----------------------------------------");

            Console.WriteLine("1. Tambah Mahasiswa");
            Console.WriteLine("2. Tampilkan Mahasiswa");
            Console.WriteLine("3. Cari Mahasiswa");
            Console.WriteLine("4. Hapus Mahasiswa");
            Console.WriteLine("5. Keluar");
            Console.ResetColor();

            Console.WriteLine("========================================");
        }

        static void TambahMahasiswa()
        {
            Console.Clear();
            Header("TAMBAH MAHASISWA", ConsoleColor.Green);

            Console.Write("NRP   : ");
            string nrp = Console.ReadLine();

            Console.Write("Nama  : ");
            string nama = Console.ReadLine();

            Console.Write("Prodi : ");
            string prodi = Console.ReadLine();

            double ipk;
            while (true)
            {
                Console.Write("IPK   : ");
                if (double.TryParse(Console.ReadLine(), out ipk)
                    && ipk >= 0 && ipk <= 4)
                {
                    break;
                }
                Pesan("IPK harus berupa angka 0 - 4.", ConsoleColor.Red);
            }

            daftarMahasiswa.Add(new Mahasiswa(nrp, nama, prodi, ipk));
            Console.WriteLine();
            Pesan("✓ Data mahasiswa berhasil ditambahkan.", ConsoleColor.Green);
        }

        static void TampilkanMahasiswa()
        {
            Console.Clear();
            Header("DAFTAR MAHASISWA", ConsoleColor.Yellow);

            if (daftarMahasiswa.Count == 0)
            {
                Pesan("Belum ada data mahasiswa.", ConsoleColor.DarkYellow);
                return;
            }

            Console.WriteLine("{0,-12} {1,-20} {2,-20} {3,5}",
                "NRP", "Nama", "Prodi", "IPK");
            Console.WriteLine("----------------------------------------------------------");

            foreach (Mahasiswa m in daftarMahasiswa)
            {
                Console.WriteLine("{0,-12} {1,-20} {2,-20} {3,5:F2}",
                    m.NRP, m.Nama, m.Prodi, m.IPK);
            }

            Console.WriteLine("----------------------------------------------------------");
            Console.WriteLine($"Total mahasiswa: {daftarMahasiswa.Count}");
        }

        static void CariMahasiswa()
        {
            Console.Clear();
            Header("CARI MAHASISWA", ConsoleColor.Blue);

            if (daftarMahasiswa.Count == 0)
            {
                Pesan("Belum ada data mahasiswa.", ConsoleColor.DarkYellow);
                return;
            }

            Console.Write("Masukkan NRP: ");
            string nrpCari = Console.ReadLine();

            Mahasiswa ditemukan = null;
            foreach (Mahasiswa m in daftarMahasiswa)
            {
                if (m.NRP.Equals(nrpCari, StringComparison.OrdinalIgnoreCase))
                {
                    ditemukan = m;
                    break;
                }
            }

            Console.WriteLine();
            if (ditemukan != null)
            {
                Pesan("Data ditemukan!", ConsoleColor.Green);
                Console.WriteLine("NRP   : " + ditemukan.NRP);
                Console.WriteLine("Nama  : " + ditemukan.Nama);
                Console.WriteLine("Prodi : " + ditemukan.Prodi);
                Console.WriteLine("IPK   : " + ditemukan.IPK.ToString("F2"));
            }
            else
            {
                Pesan("Mahasiswa dengan NRP tersebut tidak ditemukan.", ConsoleColor.Red);
            }
        }

        static void HapusMahasiswa()
        {
            Console.Clear();
            Header("HAPUS MAHASISWA", ConsoleColor.Red);

            if (daftarMahasiswa.Count == 0)
            {
                Pesan("Belum ada data mahasiswa.", ConsoleColor.DarkYellow);
                return;
            }

            Console.Write("Masukkan NRP: ");
            string nrpHapus = Console.ReadLine();

            Mahasiswa ditemukan = null;
            foreach (Mahasiswa m in daftarMahasiswa)
            {
                if (m.NRP.Equals(nrpHapus, StringComparison.OrdinalIgnoreCase))
                {
                    ditemukan = m;
                    break;
                }
            }

            if (ditemukan == null)
            {
                Pesan("Mahasiswa tidak ditemukan.", ConsoleColor.Red);
                return;
            }

            Console.WriteLine();
            Console.WriteLine("Data yang akan dihapus:");
            Console.WriteLine("Nama  : " + ditemukan.Nama);
            Console.WriteLine("Prodi : " + ditemukan.Prodi);
            Console.WriteLine("IPK   : " + ditemukan.IPK.ToString("F2"));
            Console.WriteLine();

            Console.Write("Yakin ingin menghapus? (y/n): ");
            string konfirmasi = Console.ReadLine();

            if (konfirmasi != null &&
                konfirmasi.Equals("y", StringComparison.OrdinalIgnoreCase))
            {
                daftarMahasiswa.Remove(ditemukan);
                Console.WriteLine();
                Pesan("✓ Data mahasiswa berhasil dihapus.", ConsoleColor.Green);
            }
            else
            {
                Console.WriteLine();
                Pesan("Penghapusan dibatalkan.", ConsoleColor.Yellow);
            }
        }

        static void Header(string judul, ConsoleColor warna)
        {
            Console.ForegroundColor = warna;
            Console.WriteLine("========================================");
            Console.WriteLine(" " + judul);
            Console.WriteLine("========================================");
            Console.ResetColor();
            Console.WriteLine();
        }

        static void Pesan(string pesan, ConsoleColor warna)
        {
            Console.ForegroundColor = warna;
            Console.WriteLine(pesan);
            Console.ResetColor();
        }
    }
}
