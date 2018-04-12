@php
    $connectRepo = new \Btybug\FrontSite\Repository\CmsConnectionsRepository();
    $connects = $connectRepo->pluck('name','id')->toArray();
@endphp
<div class="col-md-12">
    <div class="row  visibility-box">
        <div class="bty-panel-collapse">
            <div>
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#inputsetting"
                   aria-expanded="true">
                    <span class="icon"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    <span class="title">General Settings</span>
                </a>
            </div>
            <div id="inputsetting" class="collapse in" aria-expanded="true" style="">
                <div class="content bty-settings-panel">
                    <div class="form-group col-md-12">
                        <div class="col-md-2">
                            <label>Select connection</label>
                        </div>
                        <div class="col-md-9">
                            {!! Form::select('connect',['' => 'Select Connection']+$connects,null,
                            ['class' => 'form-control pull-right']) !!}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





