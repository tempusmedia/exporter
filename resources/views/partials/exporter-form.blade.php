<form action="{{ route('export') }}" method="get">



    <div class="form-row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Select Site
            <a href="{{ $site['store_url'] }}" target="_blank"><i class="fa fa-fw fa-external-link"></i></a>
        </label>

        <div class="col col-6">
            <i class="fa fa-2x fa-spinner fa-spin float-right"
               id="spinner"
               style="display: none; position: absolute; right: 25px; top: 5px;"></i>

            <select class="form-control" name="site"
                    onchange="this.options[this.selectedIndex].value && $('#spinner').show() && (window.location = '?site=' + this.options[this.selectedIndex].value);">

                @foreach($sites as $site)
                    <option value={{$site['id']}} @if(request('site') == $site['id']) selected @endif>{{ $site['name'] }}</option>
                @endforeach
            </select>

        </div>

        <div class="col col-2">
            <button type="button" class="btn  btn-block btn-success" data-toggle="modal" data-target="#addSite"
                    data-whatever="@getbootstrap">Add Site <i class="fa fa-fw fa-plus-circle"></i>
            </button>
        </div>
        <div class="col col-2">
            <button type="button" class="btn  btn-block btn-secondary" data-toggle="modal" data-target="#howTo"
                    data-whatever="@getbootstrap">Help <i class="fa fa-fw fa-question-circle"></i>
            </button>
        </div>

    </div>

    @if ($errors->any())
        <br>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif
        <p class="border-bottom pb-1 mb-2 mt-4">Filter Options</p>

    <div class="form-row">

        {{ csrf_field() }}
        <div class="col col-4">
        <label class="text-muted">Category <small>({{ $categories->count() }})</small></label>
        <select class="form-control" name="category">
            <option value="0">All</option>
            @foreach($categories as $category)
                <option value={{$category['id']}}
                @if(old('category') == $category['id']) selected @endif
                >{{ $category['name'] }} </option>
            @endforeach
        </select>
        </div>

        <div class="col col-2">
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

        <div class="col-2">
            <label class="text-muted">Status</label>
            <select name="status" class="form-control">
                <option value="publish">Published</option>
                <option value="any">Any</option>
                <option value="draft">Draft</option>
                <option value="pending">Pending</option>
                <option value="private">Private</option>
            </select>
        </div>

        <div class="col-2">
            <label class="text-muted">Stock</label>
            <select name="stock_status" class="form-control">
                <option value="instock">In Stock</option>
                <option value="outofstock">Out of Stock</option>
                <option value="onbackorder">On Backorder</option>
            </select>
        </div>

        <div class="col-2">
            <label class="text-muted">&nbsp;</label>
            <button class="btn btn-primary  btn-block" type="submit">Export <i class="fa fa-fw fa-cogs"></i></button>
        </div>
    </div>
</form>
<br>

