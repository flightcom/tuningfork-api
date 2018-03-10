@if(authorized('actionlog_index'))
    <div class="panel panel-default">
    <?php
    $perPage = request()->input('perPage');
    $logs = \ActionLogsManager::query(
            $model->id,
            get_class($model),
            $perPage ? $perPage : 15
    );
    ?>

    <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6 col-sm-9 col-md-10">
                    <h4>Action logs</h4>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-2 text-right">
                    {!! Form::open(array(
        'method' => 'GET',
        'id' => 'per-page-form'
    )) !!}
                    {!! Form::label('perPage', 'Per Page') !!}
                    {!! Form::select('perPage', [
                        '15' => 15,
                        '25' => 25,
                        '50' => 50,
                        '100' => 100
                    ], $logs->perPage(), [
                        'class' => 'form-control form-group',
                        'id' => 'per-page-selector'
                    ]) !!}
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Action</th>
                <th class="hide-table-xs">Pre-update</th>
            </tr>
            </thead>

            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->created_at }}</td>
                    @if ($log->user)
                        <td>{{ $log->user->first_name }} {{ $log->user->last_name }}</td>
                    @else
                        <td>N/A</td>
                    @endif

                    <td>{{ $log->type }}</td>

                    @if ($log->old)
                        <?php $old = unserialize($log->old); ?>
                        <td class="hide-table-xs">
                            @foreach($old->toArray() as $key => $value)
                                <p>{{ $key }} : {{ $value }}</p>
                            @endforeach
                        </td>
                    @else
                        <td class=""hide-table-xs"">N/A</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <nav class="pagination-container" aria-label="pagination">
        {!! $logs->appends([
                'perPage' => request()->input('perPage')
            ])->render() !!}
    </nav>
@endif