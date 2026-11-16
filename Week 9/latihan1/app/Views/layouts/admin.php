<!DOCTYPE html>
<html lang="id">

<head>
    <?= $this->include('admin/_partials/head') ?>
</head>

<body id="page-top">

    <div id="wrapper">

        <?= $this->include('admin/_partials/sidebar') ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?= $this->include('admin/_partials/navbar') ?>

                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>

            </div>

            <?= $this->include('admin/_partials/footer') ?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?= $this->include('admin/_partials/scripts') ?>

</body>
</html>