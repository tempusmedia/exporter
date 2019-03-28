@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pt-3 pb-1"><h1 class="text-center">
                            <img src="https://woocommerce.com/wp-content/themes/woo/images/logo-woocommerce.png" alt="">
                            <b>EXPORTER</b>
                        </h1></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <form action="{{ route('export') }}" method="get">

                            <div class="form-row">
                                <div class="col col-6">
                                    <label class="text-muted">Site</label>
                                    <select class="form-control" name="site">
                                        @foreach($sites as $site)
                                            <option value={{$site['id']}}>{{ $site['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col col-6">
                                    <label class="text-muted">Category</label>
                                    <select class="form-control" name="category">
                                        <option value="0">All</option>
                                        @foreach($categories as $category)
                                            <option value={{$category['id']}}>{{ $category['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <br>

                            <div class="form-row">

                                {{ csrf_field() }}

                                <div class="col col-3">
                                    <label class="text-muted">Type</label>
                                    <select name="type" class="form-control">
                                        <option value="XLSX">XLSX</option>
                                        <option value="XLS">XLS</option>
                                        <option value="CSV">CSV</option>
                                        <option value="TSV">TSV</option>
                                        <option value="ODS">ODS</option>
                                        <option value="HTML">HTML</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="text-muted">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="publish">Published</option>
                                        <option value="any">Any</option>
                                        <option value="draft">Draft</option>
                                        <option value="pending">Pending</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="text-muted">Stock</label>
                                    <select name="stock_status" class="form-control">
                                        <option value="instock">In Stock</option>
                                        <option value="outofstock">Out of Stock</option>
                                        <option value="onbackorder">On Backorder</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="text-muted">&nbsp;</label>
                                    <button class="btn btn-primary  btn-block" type="submit">Export</button>
                                </div>
                            </div>
                        </form>
                            <hr>
                            <div class="form-row">

                                <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>File name</th>
                                    <th style="text-align: center">Type</th>
                                    <th style="text-align: right">Action</th>
                                    </thead>
                                    <tbody>

                                    @foreach($exports->sortByDesc('id') as $file)
                                        <tr>
                                            <td>{{ $file->created_at->format('d.m.Y') }}</td>
                                            <td>{{ $file->created_at->format('H:i') }}</td>
                                            <td>{{ $file->name }}</td>
                                            <td style="text-align: center"><span class="badge badge-secondary ">{{ $file->type }}</span></td>
                                            <td><a href="{{ route('download', $file->name) }}" class="btn btn-sm btn-success float-right">Download</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
