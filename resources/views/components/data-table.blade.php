<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{$title}}</h3>
        <div class="card-tools">
            {{$tools}}
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table id="{{$id}}" class="table table-bordered table-hover">
            <thead>
                <tr>
                    {{$column}}
                </tr>
            </thead>
            <tfoot>
                <tr>
                    {{$column}}
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>