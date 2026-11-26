@extends('layouts.master')

@section('content')




    <!-- main header @e -->
    <!-- content @s
                                                        -->
        <div class="nk-content ">
            <div class="container-fluid">
                <div class="nk-content-inner">
                    <div class="nk-content-body">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">Activity Logs</h3>
                                    <div class="nk-block-des text-soft">
                                        <p>Audit trail of portal user actions, approvals, and system events.</p>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                    <div class="toggle-wrap nk-block-tools-toggle">
                                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                            data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                        <div class="toggle-expand-content" data-content="more-options">
                                            <ul class="nk-block-tools g-3">






                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">

                            <div class="card card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init table">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;">No</th>
                                                <th>Subject</th>
                                                <th>IP Address</th>
                                                <th>User Email</th>
                                                <th>Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($logs->count())
                                                @foreach ($logs as $key => $log)
                                                    <tr>
                                                        <td class="text-muted">{{ ++$key }}</td>
                                                        <td style="white-space: normal; min-width: 280px; font-weight: 500; color: #0f172a;">{{ $log->subject }}</td>
                                                        <td>
                                                            <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-family: monospace; font-size: 11.5px;">
                                                                {{ $log->ip }}
                                                            </span>
                                                        </td>
                                                        <td style="color: #0c2b70;">{{ $log->user_email }}</td>
                                                        <td class="text-nowrap" style="color: #64748b;">
                                                            {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('M. d, Y') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-preview -->
                </div><!-- .nk-block -->
            </div>
        </div>
        </div>
        </div>
        <!-- content @e -->
        <!-- @@ Group Add Modal @e -->


    @endsection
