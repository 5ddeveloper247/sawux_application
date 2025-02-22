@extends('layouts.super_admin.master')

@push('css')
@endpush

@section('content')
    <div>
        <div class="px-3 py-4" data-page="exam">
            <form>
                <div class="sub-bg rounded-4 p-3">
                    <div class="table-responsive">
                    <table id="exam-listing" style="width: 100%" class="listing_table table table-responsive">
                        <thead class="postion-sticky top-0">
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col">User Detail</th>
                                <th scope="col">Action</th>
                                <th scope="col">Module</th>
                          
                                <th scope="col">Message</th>
                          
                                <th scope="col">Data & Time</th>
                            </tr>
                        </thead>
                    </table>
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
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'user_detail',
                            name: 'user_detail'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'module',
                            name: 'module'
                        },
                        {
                            data: 'short_message',
                            name: 'short_message'
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
