@extends('layouts.super_admin.master')

@push('css')
@endpush

@section('content')
    <div>
        <div class="p-md-4 p-3" data-page="exam">
            <form>
                <div id="products">
                    <div class="px-4 pt-4 pb-5 bg-white shadow">
                        <div class="table-responsive">
                        <table id="exam-listing" style="width: 100%" class="listing_table table table-responsive">
                            <thead>
                                <tr>

                                    <th scope="col">Module</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">User Detail</th>
                                    <th scope="col">Data & Time</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            pageLoader();
            function pageLoader() {


                var table = $('#exam-listing').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    ajax: {
                        url: "{{ route('superadmin.audit.trails.list') }}", // URL to your route
                        type: 'POST', // Specify the HTTP method as POST
                    },
                    columns: [{
                            data: 'module',
                            name: 'module'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'short_message',
                            name: 'short_message'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'user_detail',
                            name: 'user_detail'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                    ]
                });

            }
         
        });
    </script>
@endpush
