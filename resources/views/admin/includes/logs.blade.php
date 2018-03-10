@if(authorized('actionlog_index'))
    <?php
        $perPage = request()->input('perPage');
        $data = \ActionLogsManager::query(
                $model->id,
                get_class($model),
                $perPage ? $perPage : 15
        );
    ?>

    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="box-title">Action logs</h3>
                        </div>

                        <div class="col-xs-6">
                            @include('admin.includes.resource.perpage')
                        </div>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Action</th>
                            <th class="hide-table-xs">Pre-update</th>
                        </tr>
                        @foreach($data as $log)
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
                                    <td class="hide-table-xs">N/A</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h5>
                @include('admin.includes.resource.entries', [
                    'data' => $data
                ])
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @include('admin.includes.resource.pagination')
        </div>
    </div>
@endif

