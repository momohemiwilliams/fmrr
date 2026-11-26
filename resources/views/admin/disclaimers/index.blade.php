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
                                    <h3 class="nk-block-title page-title">Disclaimers</h3>
                                    <div class="nk-block-des text-soft">
                                        <p>Record of legal disclaimer acceptances across internal and external portal users.</p>
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
                                    <table class="datatable-init nowrap table">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;">S/N</th>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>IP Address</th>
                                                <th>Accepted At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($acceptances as $acceptance)
                                                @php
                                                    $accUserName = $acceptance->user->name ?? 'N/A';
                                                    $accInitials = strtoupper(substr($accUserName, 0, 2));
                                                @endphp
                                                <tr>
                                                    <td class="text-muted">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="mr-2" style="width: 30px; height: 30px; border-radius: 50%; background: #eef2f7; color: #0c2b70; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #dbe4f0; flex-shrink: 0;">
                                                                {{ $accInitials }}
                                                            </span>
                                                            <span style="font-weight: 600; color: #0f172a;">{{ $accUserName }}</span>
                                                        </div>
                                                    </td>
                                                    <td style="color: #0c2b70;">{{ $acceptance->user->email ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-family: monospace; font-size: 11.5px;">
                                                            {{ $acceptance->ip_address ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td style="color: #64748b;">
                                                        {{ \Carbon\Carbon::parse($acceptance->created_at)->addHour()->format('M. j, Y g:i:s A') }}
                                                    </td>
                                                </tr>
                                            @endforeach
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

@endsection