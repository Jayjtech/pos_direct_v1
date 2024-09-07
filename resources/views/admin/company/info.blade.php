@extends('layouts.user')
@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h1 class="font-weight-bold mb-2">COMPANY INFO</h1>
                    <form action="{{ route('admin.save.company.info') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3 row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('ui/' . companyInfo()->company_logo) }}" class="img-thumbnail"
                                            id="logoPreview" width="150" height="150">
                                    </div>
                                    <div class="col-8">
                                        <label for="signature">Company logo</label><br>
                                        <input type="file" name="logo" id="logo" accept=".png,.jpg,.gif"
                                            onchange="previewLogo();" class="btn btn-sm btn-primary mt-3">
                                    </div>
                                </div>
                            </div>
                            {{-- row ID --}}
                            <input type="hidden" name="row_id" value="{{ companyInfo()->id }}">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('ui/' . companyInfo()->company_signature) }}"
                                            class="img-thumbnail" id="signaturePreview" width="150" height="150">
                                    </div>
                                    <div class="col-8">
                                        <label for="signature">Company signature</label><br>
                                        <input type="file" name="signature" id="signature" accept=".png,.jpg"
                                            onchange="previewSignature();" class="btn btn-sm btn-primary mt-3">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="company_name">Company name</label>
                                    <input type="text" name="company_name" class="form-control"
                                        placeholder="Company name..." value="{{ companyInfo()->company_name }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="company_name">Company email</label>
                                    <input type="text" name="company_email" class="form-control"
                                        placeholder="Company email..." value="{{ companyInfo()->company_email }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="company_name">Company phone number I</label>
                                    <input type="text" name="company_phone_i" class="form-control"
                                        placeholder="Company phone number..." value="{{ $phone_i }}">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="company_name">Company phone number II</label>
                                    <input type="text" name="company_phone_ii" class="form-control"
                                        placeholder="Company phone number..." value="{{ $phone_ii }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="company_address">Company address</label>
                                    <textarea name="company_address" class="form-control" placeholder="Company address..." rows="3">{{ companyInfo()->company_address }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="logo_status">Logo status</label>
                                    <select name="logo_status" class="form-control">
                                        <option
                                            value="{{ companyInfo()->logo_status }}  
                                        ">
                                            @if (companyInfo()->logo_status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </option>

                                        <option
                                            value="
                                        @if (companyInfo()->logo_status == 1) 0
                                            @else
                                            1 @endif
                                        ">
                                            @if (companyInfo()->logo_status == 1)
                                                Inactive
                                            @else
                                                Active
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="signature_status">Signature status</label>
                                    <select name="signature_status" class="form-control">
                                        <option
                                            value="{{ companyInfo()->signature_status }}  
                                        ">
                                            @if (companyInfo()->signature_status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </option>

                                        <option
                                            value="
                                        @if (companyInfo()->signature_status == 1) 0
                                            @else
                                            1 @endif
                                        ">
                                            @if (companyInfo()->signature_status == 1)
                                                Inactive
                                            @else
                                                Active
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3 mt-3">
                                <div class="form-group">
                                    <label for="discount_mode">Shop: Product discount mode</label>
                                    <select name="discount_mode" class="form-control">
                                        <option
                                            value="{{ companyInfo()->discount_mode }}  
                                        ">
                                            @if (companyInfo()->discount_mode == 1)
                                                By Percentage
                                            @else
                                                By Amount
                                            @endif
                                        </option>

                                        <option
                                            value="
                                        @if (companyInfo()->discount_mode == 1) 0
                                            @else
                                            1 @endif
                                        ">
                                            @if (companyInfo()->discount_mode == 1)
                                                By Amount
                                            @else
                                                By Percentage
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <div class="form-group">
                                    <label for="discount_visibility">Discount Visibility</label>
                                    <select name="discount_visibility" class="form-control">
                                        <option
                                            value="{{ companyInfo()->discount_visibility }}  
                                        ">
                                            @if (companyInfo()->discount_visibility == 1)
                                                By Admin
                                            @else
                                                By Sales person
                                            @endif
                                        </option>

                                        <option
                                            value="
                                        @if (companyInfo()->discount_visibility == 1) 0
                                            @else
                                            1 @endif
                                        ">
                                            @if (companyInfo()->discount_visibility == 1)
                                                By Sales person
                                            @else
                                                By Admin
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3 mb-3" align="right">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        @endsection

        @include('admin.js.company_js')
