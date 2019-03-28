@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">WooCommerce to AdWords Exporter</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="{{ route('download') }}" method="get" >
                                {{ csrf_field() }}
                                <select name="category" >
                                    <option value="0"> Sve</option>
                                    @foreach($categories as $category)
                                        <option value={{$category['id']}}>{{ $category['name'] }} </option>
                                    @endforeach
                                </select>
                                <select name="format">
                                    <option value="XLSX">XLSX</option>
                                    <option value="XLS">XLS</option>
                                    <option value="CSV">CSV</option>
                                    <option value="TSV">TSV</option>
                                    <option value="ODS">ODS</option>
                                    <option value="HTML">HTML</option>
                                </select>
                                <button class="btn btn-primary btn-sm" type="submit">Export</button>
                            </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
