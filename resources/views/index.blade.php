@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header pt-4 pb-2"><h1 class="text-center">
                            <img src="https://woocommerce.com/wp-content/themes/woo/images/logo-woocommerce.png" alt="">
                            <b>EXPORTER</b>
                        </h1>
                    </div>

                    <div class="card-body">

                        @include('flash::message')

                        <diw class="row">
                            <div class="col col-md-12">
                                @if(!$sites->isEmpty())
                                    @include('partials.exporter-form')
                                @else
                                    <div class="form-group row">

                                        <div class="col col-6">
                                            <h5 class="text-center pt-2">Add Site</h5>
                                        </div>

                                        <div class="col col-3">
                                            <button type="button" class="btn  btn-block btn-success" data-toggle="modal"
                                                    data-target="#addSite"
                                                    data-whatever="@getbootstrap">Add Site
                                            </button>
                                        </div>
                                        <div class="col col-3">
                                            <button type="button" class="btn  btn-block btn-success" data-toggle="modal"
                                                    data-target="#howTo"
                                                    data-whatever="@getbootstrap">Help
                                            </button>
                                        </div>

                                    </div>

                                @endif


                            </div>

                        </diw>

                        <div class="form-row">
                            <div class="col col-md-12">
                                @if(!$exports->isEmpty())

                                    <p class="text-dark mb-1 mt-3">Site Exports</p>

                                    @include('partials.exports-table')
                                @else
                                    <div class="alert alert-primary" role="alert">
                                        <h4 class="text-center mt-2">No Exports Created!</h4>
                                        <p class="text-center">Select your site and create your first export!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </div>

@include('partials.modals')

    <script>
        $('#addSite').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
        })
        $('#howTo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
        })
    </script>

@endsection
