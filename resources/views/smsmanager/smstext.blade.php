@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
            <div class="alert alert-success" id="success-alert">Sms muvaffaqqiyatli yuborildi!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>SmsManager</h2>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Sms yuborish</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card animate__animated animate__fadeInUp">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="{{route('send_message_tg')}}"><i class="fa fa-telegram"></i> Telegram</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('send_message') }}"><i class="fa fa-home"></i> Sms
                        yuborish</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('success_message') }}"><i class="fa fa-user"></i>
                        Yuborilgan smslar </a></li>
                <li class="nav-item"><a class="nav-link active show" href="{{ route('sms_text') }}"><i
                            class="fa fa-comment"></i> SmsText </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active">
                    <div class="card">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <h6 style="font-weight: bold">Matn qo'shish:</h6>
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <input type="text" placeholder="Matnni kiriting ..." class="form-control"
                                                name="textNew" id="textNew">
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary" style="width: 100%" onclick="AddText()"> <i
                                                    class="fa fa-plus"></i> Qo'shish</button>
                                        </div>
                                    </div>
                                    <h6 style="font-weight: bold">O'zgaruvchilarni tanlang:</h6>
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action active">
                                            Qo'shiladigan qiymatlar:
                                        </button>
                                        <button type="button" onclick="summa()"
                                            class="list-group-item list-group-item-action" style="font-weight: bold">
                                            Qabul qilingan summa</button>
                                        <button type="button" onclick="yetqazilgan()"
                                            class="list-group-item list-group-item-action" style="font-weight: bold">
                                            Yetqazilgan taralar soni</button>
                                        <button type="button" onclick="tara()"
                                            class="list-group-item list-group-item-action" style="font-weight: bold">
                                            Qabul qilingan taralar soni</button>
                                        <button type="button" onclick="oldindan()"
                                            class="list-group-item list-group-item-action" style="font-weight: bold">
                                            Oldindan to'lov</button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <h6 style="font-weight: bold">Sms Text ko'rinishi:</h6>
                                    <textarea class="form-control mb-3" name="viewText" id="viewText" cols="30" rows="10" disabled>{{$smsText->full_sms_text ?? ''}}</textarea>
                                    <div class="alert alert-warning alert-dismissible mb-3" role="alert">
                                        <i class="fa fa-warning"></i> Example: Qabul qilingan summa ((qabul-qilingan-summa)), 
                                        Yetqazilgan taralar soni ((yetqazilgan-taralar-soni)).
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-primary" onclick="clearText()" style="width: 100%"><i
                                                    class="fa fa-ban"></i> Matnni tozalash </button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-success" onclick="sendNewText()" style="width: 100%"><i
                                                    class="fa fa-save"></i> Saqlash </button>
                                        </div>
                                    </div>
                                </div>
                                <textarea style="display: none" class="form-control mb-3" name="sendText" id="sendText" cols="30" rows="10" disabled></textarea>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        
        function AddText() {
            let txt = $('#textNew').val();
            let viewText = $('#viewText').val();
            $('#viewText').val(viewText + txt);

            let sendText = $('#sendText').val();
            $('#sendText').val(sendText + '&'+ txt);
        }

        function summa() {
            let txt = "((qabul-qilingan-summa))";
            let viewText = $('#viewText').val();

            $('#viewText').val(viewText + txt);
            let sendText = $('#sendText').val();
            $('#sendText').val(sendText + '&'+ txt);
        }

        function yetqazilgan() {
            let txt = "((yetqazilgan-taralar-soni))";
            let viewText = $('#viewText').val();

            $('#viewText').val(viewText + txt);
            let sendText = $('#sendText').val();
            $('#sendText').val(sendText + '&'+ txt);
        }

        function tara() {
            let txt = "((qabul-qilingan-taralar-soni))";
            $('#sendText').val(sendText + '&'+ txt);

            $('#viewText').val(viewText + txt);
            let sendText = $('#sendText').val();
            $('#sendText').val(sendText + '&'+ txt);
        }

        function oldindan() {
            let txt = "((oldindan-tulov))";
            let viewText = $('#viewText').val();

            $('#viewText').val(viewText + txt);
            let sendText = $('#sendText').val();
            $('#sendText').val(sendText + '&'+ txt);
        }

        function sendNewText() {
            let sendText = $('#sendText').val();
            let viewText = $('#viewText').val();

            if(sendText!='')
                sendText = sendText + '&';

            $.ajax({
                type: 'POST',
                url: "{{ route('sms_text_new') }}",
                data: {
                    "a": sendText,
                    "b": viewText,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    swal("Muvaffaqqiyatli!", "You clicked the button!", "success");
                },
                error: function(error) {
                    swal({
                        title: "Xatolik!",
                        text: error.responseJSON.message,
                        imageUrl: "https://media.istockphoto.com/photos/exclamation-point-gold-exclamation-mark-3d-sign-symbol-icon-isolated-picture-id1053873894?k=6&m=1053873894&s=170667a&w=0&h=SVubyN6Q1Cxe3Eg0KV1h7-bXAuQB3-V_xVUyc1hWHPs="
                    });
                }
            });
        }

        function clearText() {
            $('#viewText').val('');
            $('#sendText').val('');

            Toastify({
                text: "Muvaffaqqiyatli tozalandi!",
                className: "info",
                gravity: "bottom",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
            }).showToast();

            console.log(a);
        }
    </script>
@endsection
