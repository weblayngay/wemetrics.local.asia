<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $reports = !empty($data['reports']) ? $data['reports'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
    $htmlDataStudio = isset($data['htmlDataStudio']) ? $data['htmlDataStudio'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.ggadwords.ggadwords_report'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <fieldset class="form-group">
                            {!! $htmlDataStudio !!}
                        </fieldset>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
