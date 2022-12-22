<?php
    $title = isset($data['title']) ? $data['title'] : '';
    $sources = isset($data['sources']) ? $data['sources'] : null;
    $mediums = isset($data['mediums']) ? $data['mediums'] : null;
    $campaigns = isset($data['campaigns']) ? $data['campaigns'] : null;
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.utmcreator.utmcreator_index'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('utmcreator', 'index')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        @csrf
        <input type="hidden" name="typeSubmit" value="0">
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">{{__('Thông tin (Tiếng Việt)')}}</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-vi" role="tabpanel" aria-labelledby="nav-vi-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="website_url">{{__('Website URL')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="website_url" id="website_url" class="form-control" placeholder="Website URL" required="">
                                                            <span class="small">The full website URL (e.g. <span><strong>https://www.example.com</strong></span>)</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_id">{{__('Campaign Id')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="campaign_id" id="campaign_id" class="form-control" placeholder="Campaign Id">
                                                            <span class="small">The ads campaign id.</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_source">{{__('Campaign Source')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            {{-- <input type="text" name="campaign_source" id="campaign_source" class="form-control" placeholder="Campaign Source" required=""> --}}
                                                            <select class="form-control select2" name="campaign_source" id="campaign_source">
                                                                <option value="">{{__('Campaign Source')}}</option>
                                                                @foreach($sources as $key => $item)
                                                                    <option value="{{($item->id)}}">
                                                                        {{($item->name)}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="small">The referrer (e.g. <span><strong>google</strong></span>, <span><strong>newsletter</strong></span>)</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_medium">{{__('Campaign Medium')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            {{-- <input type="text" name="campaign_medium" id="campaign_medium" class="form-control" placeholder="Campaign Medium" required=""> --}}
                                                            <select class="form-control select2" name="campaign_medium" id="campaign_medium">
                                                                <option value="">{{__('Campaign Medium')}}</option>
                                                                @foreach($mediums as $key => $item)
                                                                    <option value="{{($item->id)}}">
                                                                        {{($item->name)}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="small">Marketing medium (e.g. <span><strong>cpc</strong></span>, <span><strong>banner</strong></span>, <span><strong>email</strong></span>)</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_name">{{__('Campaign Name')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            {{-- <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Campaign Name" required=""> --}}
                                                            <select class="form-control select2" name="campaign_name" id="campaign_name">
                                                                <option value="">{{__('Campaign Name')}}</option>
                                                                @foreach($campaigns as $key => $item)
                                                                    <option value="{{($item->id)}}">
                                                                        {{($item->name)}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="small">Product, promo code, or slogan (e.g. <span><strong>spring_sale</strong></span>) One of campaign name or campaign id are required.</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_term">{{__('Campaign Term')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="campaign_term" id="campaign_term" class="form-control" placeholder="Campaign Term">
                                                            <span class="small">Identify the paid keywords</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="campaign_content">{{__('Campaign Content')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="campaign_content" id="campaign_content" class="form-control" placeholder="Campaign Content">
                                                            <span class="small">Use to differentiate ads</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="creator_url">{{__('Creator URL')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="MuiPaper-root jss49 jss24 MuiPaper-elevation1 MuiPaper-rounded">
                                                                <section data-testid="bad-url-warnings" id="Muipaper_badURL" name="Muipaper_badURL">
                                                                  <section class="jss50">
                                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path></svg>
                                                                    <p class="MuiTypography-root MuiTypography-body1">The website URL provided is not a valid URL.</p>
                                                                  </section>
                                                                </section>

                                                                <section data-testid="fill-out-url-warnings" id="Muipaper_FilloutURL" name="Muipaper_FilloutURL">
                                                                  <section class="jss50">
                                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path></svg>
                                                                    <p class="MuiTypography-root MuiTypography-body1">Fill out required fields above and a URL will be generated for you here..</p>
                                                                  </section>
                                                                </section>

                                                                <section data-testid="url-success" id="Muipaper_Success" name="Muipaper_Success">
                                                                  <div class="wemetrics-analyzer-header mb-2">
                                                                      <h3 class="tab-title">Share the generated campaign URL</h3>
                                                                  </div>
                                                                  <div class="text-secondary mb-2">
                                                                      Use this URL in any promotional channels you want to be associated with this custom campaign.
                                                                  </div>
                                                                  <section class="jss50">
                                                                      <textarea class="wemetrics-utm-creator-input generate-url" type="text" id="generated_url" name="generated_url" placeholder="Generated Url" readonly=""></textarea>
                                                                      <a href="javascript:copyGeneratedUrl();"><svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" id="copy_generated_url" name="copy_generated_url">
                                                                      <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4l6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2h7zm-1 7h5.5L14 6.5V12z"></path>
                                                                      </svg></a>
                                                                  </section>
                                                              </section>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
@section('javascript_tag')
@parent

@include('backend.elements.ajax.utmcreator.utmcreator_index')

@endsection