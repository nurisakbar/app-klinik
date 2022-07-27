<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$detail->jumlah_antrian}}</h3>
                <p>Jumlah Antrian</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-list"></i>
            </div>
            
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$detail->antrian_sekarang ? $detail->antrian_sekarang : 'Belum ada '}}<sup style="font-size: 20px"></sup></h3>

                <p>Antrian Saat ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-checkmark-circle"></i>
            </div>
            
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$detail->antrian_selanjutnya ? $detail->antrian_selanjutnya : 0}}</h3>

                <p>Antrian Selanjutnya</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$detail->sisa_antrian}}</h3>

                <p>Sisa antrian</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-people"></i>
            </div>
            
        </div>
    </div>
    <!-- ./col -->
</div>