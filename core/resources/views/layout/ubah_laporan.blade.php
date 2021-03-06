@extends('layout.template')
<?php
//ambil nama depan & belakang
$user = Auth::user();

$username = NULL;
$query_nama = DB::table('users')
        ->select('*')
        ->where('id', '=', $user->id)
        ->get();

foreach ($query_nama as $query_nama1) {
    $username = $query_nama1->username;
}

$id_topik = NULL;
$nama_topik = NULL;
$deskripsi_topik = NULL;
$class_warna = NULL;
foreach ($topik as $topik1) {
    $id_topik = $topik1->id;
    $nama_topik = $topik1->nama_topik;
    $deskripsi_topik = $topik1->deskripsi_singkat;
    $class_warna = $topik1->class_warna;
}

$resume = NULL;
foreach ($resume_topik as $resume_topik1) {
    $resume = $resume_topik1->resume;
}
?>
@section('judul-halaman')
    <title>Ubah Resume <?php echo $nama_topik;?> | PRD Online Course</title>
@endsection
@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a></li>
                <li><a href="{{url('user')}}/<?php echo $username;?>/profil" class="blue-text thin">Profil</a></li>
                <li>
                    <!-- Dropdown Trigger -->
                    <a class='dropdown-button blue-text thin' href='#' data-activates='dropdown1'>
                        <?php echo $user->username;?>
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id='dropdown1' class='dropdown-content'>
                        <li><a href="{{url('logout')}}">Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a></li>
                <li><a href="{{url('user')}}/<?php echo $username;?>/profil" class="blue-text thin">Profil</a></li>
                <li><a href="{{url('logout')}}" class="blue-text thin">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="section <?php echo $class_warna;?>">
        <div class="container row center-align" style="padding: 8em 0 5em 0">

            <h2 class="white-text"><?php echo $nama_topik;?></h2>
            <div class="col s12">
                <a href="../../../dashboard" class="breadcrumb">Daftar Topik</a>
                <a href="../../<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="breadcrumb">Pendahuluan</a>
                <a href="../../sub_topik/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="breadcrumb">Sub
                    Topik</a>
                <a href="../<?php echo str_replace(' ', '-', strtolower($nama_topik));?>" class="breadcrumb">Resume</a>
                <a href="#" class="breadcrumb">Ubah Resume</a>
            </div>
        </div>
    </div>

    <div class="section white black-text">
        <div class="container row" style="padding: 4em 0 4em 0">
            <div id="video" class="col s12 center-align">
                <h5>Ketentuan</h5>
                <p class="thin">Karena video diunggah melalui youtube harap diperhatikan aturan yang berlaku.<br/>
                    Video resume yang dibuat <b>harus menampilkan wajah anda</b>.
                </p>
                <br/>

                <form action="{{url('resume/video')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="id_topik" value="<?php echo $id_topik;?>"/>
                    <input type="text" placeholder="https://www.youtube.com/embed/2igPl-MTfTQ" name="video"/>
                    <div class="file-field input-field">
                        <button type="submit" class="waves-effect waves-light btn blue lighten-2">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="{{url('/')}}"><img
                                src="{{url('/')}}/core/resources/assets/images/logoShortcutIcon.png"/></a>
                    <p class="blue-text thin">© 2017 PPTIK Institut Teknologi Bandung</p>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('js')
    $(document).ready(function(){

    $('select').material_select();

    $('.modal-trigger').leanModal();

    $('a').smoothScroll({
    speed:1000
    });

    $('.tooltipped').tooltip({delay: 50});

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    $('.collapsible').collapsible({
    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });

    //CKEDITOR.replace( 'editor1' );

    $('ul.tabs').tabs();

    });
@endsection
