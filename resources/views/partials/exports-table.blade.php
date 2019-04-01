<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <th>Date</th>
        <th>Time</th>
        <th>File name</th>
        <th style="text-align: center">Type</th>
        <th style="text-align: right; width: 90px;">Action</th>
        </thead>
        <tbody>

        @foreach($exports as $file)
            <tr>
                <td>{{ $file->created_at->format('d.m.Y') }}</td>
                <td>{{ $file->created_at->format('H:i') }}</td>
                <td>{{ $file->name }}</td>
                <td style="text-align: center"><span
                            class="badge badge-secondary ">{{ $file->type }}</span></td>
                <td>
                    <a href="{{ route('download', $file->name) }}"
                       class="btn btn-sm btn-success float-right ml-1"><i
                                class="fa fa-download"></i></a>
                    <a href="{{ route('delete', $file) }}"
                       class="btn btn-sm btn-danger float-right"><i
                                class="fa fa-trash"></i></a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $exports->links() }}