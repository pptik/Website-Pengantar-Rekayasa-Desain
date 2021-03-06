@extends('layout.template')
@section('judul-halaman')
    <title>Tambah Bimbingan | PRD Online Course</title>
@endsection
@section('konten')
    <?php
    //ambil nama depan & belakang
    $user = Auth::user();
    $username = NULL;
    $status_konfirmasi = NULL;
    $universitas = NULL;
    $url_kartu_pengenal = NULL;
    $peran = NULL;

    $query = DB::table('users')
            ->select('*')
            ->join('universitas', 'universitas.id', '=', 'users.universitas')
            ->where('users.id', '=', $user->id)
            ->get();

    foreach ($query as $query) {
        $username = $query->username;
        $status_konfirmasi = $query->status_konfirmasi;
        $url_kartu_pengenal = $query->url_kartu_pengenal;
        $peran = $query->peran;
    }

    $query_universitas = DB::table('universitas')
            ->join('users', 'users.id', '=', 'universitas.id_users')
            ->where('universitas.id', '=', $user->universitas)
            ->get();

    foreach ($query_universitas as $query_universitas) {
        $universitas = $query_universitas->nama_depan . ' ' . $query_universitas->nama_belakang;
    }

    //ambil untuk penanda topik yang dipilih
    $penanda = NULL;
    foreach ($topik_dipilih as $topik_dipilih) {
        $penanda = $topik_dipilih->id;
    }
    ?>
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
                        <li></li>
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

    <br/>
    <br/>
    <br/>
    <div class="section white">
        <div class="row container-bimbingan">
            <div class="row">
                <div class="col s12">
                    <div class="center-align">

                        <h5>Bimbingan</h5>
                        <p class="thin">Apabila ada yang ingin anda tanyakan kepada dosen silahkan lakukan bimbingan
                            pada menu dibawah.
                            <br/>Bimbingan dibagi berdasarkan dengan nama topik yang berada pada tab.
                        </p>
                    </div>

                </div>
            </div>
            <br/>

            <div class="row" style="padding: 0 11em 0 11em;" class='thin'>
                <div class="col s12 m12 l3">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="card-action grey">
                                <a href="#" class="white-text" style="text-transform: capitalize;">Materi</a>
                            </div>
                            <div class="card-content" style="padding: 0;">
                                <ul class="collection" style="padding: 0;margin: 0;">
                                    {{--<li class="collection-item" style="border-left: 3px solid #2196F3;">Pengantar</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan I</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan II</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan III</li>--}}
                                    <?php
                                    foreach ($topik as $topik){
                                    if ($topik->id == $penanda){

                                    ?>
                                    <li class="collection-item"><a
                                                href="{{url('bimbingan/materi')}}/<?php echo $topik->id;?>"
                                                style="color: red;"><?php echo $topik->nama_topik;?></a>
                                    </li>
                                    <?php
                                    }else{
                                    ?>
                                    <li class="collection-item"><a
                                                href="{{url('bimbingan/materi')}}/<?php echo $topik->id;?>"
                                                style="margin-left: 3px;"><?php echo $topik->nama_topik;?></a>
                                    </li>
                                    <?php
                                    }
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l9">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="card-action grey">
                                <a href="#" class="white-text" style="text-transform: capitalize;">Form Bimbingan</a>
                            </div>
                            <div class="card-content" style="padding: 0em;">
                                <div class="row">
                                    <div class="col s12">
                                        <br>
                                        <div class="row">
                                            @if (count($errors) > 0)
                                                <div class="card container col m12 red white-text">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form class="col s12" method="post" action="{{url('proses_tambah_bimbingan/mahasiswa')}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                <input type="hidden" name="id" value="<?php echo $user->id;?>"/>
                                                <input type="hidden" name="universitas"
                                                       value="<?php echo $user->universitas;?>"/>
                                                <input type="hidden" name="topik" value="<?php echo $penanda;?>"/>

                                                <div class="row">
                                                    <div class="chip">
                                                        Setelah anda menekan tombol kirim, anda tidak dapat mengubah & menghapus pertanyaan.
                                                        <i class="close material-icons">close</i>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <select name="dosen">
                                                            <option value="" disabled selected>-</option>
                                                            <?php
                                                            foreach ($dosens as $dosen) {
                                                                //ambil nama universitas
                                                                $universitas = DB::table('users')
                                                                                ->join('universitas','universitas.id_users','=','users.id')
                                                                                ->where('universitas.id','=',$dosen->id_universitas)
                                                                                ->get();

                                                                $namaUniversitas = NULL;
                                                                foreach ($universitas as $univ){
                                                                    $namaUniversitas = $univ->nama_depan.' '.$univ->nama_belakang;
                                                                }
                                                            ?>
                                                            <option value="<?php echo $dosen->id_dosen;?>"><?php echo $dosen->nama_depan . " " . $dosen->nama_belakang;?> - <?php echo $namaUniversitas;?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <label>Dosen</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input id="judul" type="text" class="validate" name="judul">
                                                        <label for="judul">Judul</label>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <label for="permasalahan">Pertanyaan</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <textarea name="permasalahan" id="permasalahan" rows="10"
                                                                  cols="80"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <button class="waves-effect waves-light btn">kirim</button>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                                <ul class="collection" style="padding: 0;margin: 0;">
                                    {{--<li class="collection-item">Ambil ladang</li>--}}
                                </ul>


                            </div>

                        </div>
                    </div>

                </div>
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

    $('.modal-trigger').leanModal({dismissible: true});

    $('a').smoothScroll({
    speed:1000
    });

    $('.tooltipped').tooltip({delay: 50});

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    CKEDITOR.replace( 'permasalahan' );
    });
@endsection
