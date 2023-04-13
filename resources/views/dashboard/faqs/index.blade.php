@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الاسئلة الشائعة </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                                 <br>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">
                                    @include('dashboard.parts._error')
                                    @include('dashboard.parts._success')

                                    <br>

                                    <br>
                                    <table class="table table-striped table-bordered zero-configuration" id="storestable">


                                        <br>
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800">
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('السؤال') }}</th>
                                                <th>{{ __('الاجابة ') }}</th>
                                              
                                                <th>{{ __('العمليات') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sort_menu">
                                            @foreach ($faqs as $key => $item)
                                                <tr data-id="{{ $item->id }}">
                                                    {{-- {{ dd($item) }} --}}
                                    
                                                    <td> <i class="fa fa-bars handle" aria-hidden="true"></i></td>
                                                    <td>{{$item->question}}</td>
                                                    <td>{!! $item->answer !!}</td>
                                                <td>
                                                    <a href="{{ route('faqs.edit',$item->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                    <form style="display: inline"
                                                    action="{{ route('faqs.destroy', $item->id) }}"
                                                    method="post">
                                                    @method('delete') @csrf
                                                    <button type="submit" class="btn btn-danger delete-confirm"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                                   </td>
                                               
                                           
                                                @endforeach
                                    
                                    
                                        </tbody>

                                    </table>
                                    <form class="form" method="post" method="{{ route('faqs.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                               
                                                <div class="form-group col-md-12">
                                                    <label> {{ __('السؤال') }} :</label>
                                                    <input type="text" name="qus" id="qus" class="form-control form-control-solid"
                                                        placeholder="اضف سؤال" required />
                                                </div>
                                           
                                                <div class="form-group col-md-12">
                                                    <label>{{ __('الاجابة') }} :</label>
                                                    <textarea name="answer" class="form-control" required id="" cols="30" rows="5"></textarea>
                                                </div>
                                             
                                               
                                
                                
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2">{{ __('حفظ') }}</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    

    <script>
       
     
        function updateToDatabase(idString) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: '{{ route('update_sort_faqs') }}',
                method: 'POST',
                data: {
                    ids: idString
                },
                success: function() {
                    alert('Successfully updated')
                    //do whatever after success
                }
            })
        }
        var target = $('.sort_menu');
        target.sortable({
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function(e, ui) {
                var sortData = target.sortable('toArray', {
                    attribute: 'data-id'
                })
                updateToDatabase(sortData.join(','))
            }
        });
    </script>
@endsection
