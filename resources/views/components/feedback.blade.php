@extends('layouts.client')

@section('header')
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<style type="text/css">
    * {
        box-sizing: border-box;
    }
    html,body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .container {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #form-feedback {
        border: 1px solid #ccc;
        background-color: #f8f7f7;
        border-radius: 7px;
        width: 400px;
        /*height: 350px;*/
        padding: 1rem 1.5rem;
    }
    #form-feedback label,
    #form-feedback input[type=text],
    #form-feedback select,
    #form-feedback textarea {
        font-size: 1.3rem;
        color: #686868;
        display: block;
        width: 100%;
        margin-bottom: 7px;
    }
    #form-feedback label {
        font-size: 1.1rem;
        padding-bottom: 5px;
    }
    #form-feedback input[type=text],
    #form-feedback select,
    #form-feedback textarea
    {
        border-radius: 7px;
        border: 1px solid #ccc;
        padding: 5px 10px;
    }
    #form-feedback input[type=text] {
        height: 40px;
    }
    #form-feedback select {
        height: 40px;
    }
    .control {
        padding-top: 10px;
        display: flex;
        justify-content: center;
    }
    .reset,
    .submit {
        display: inline-block;
        font-size: 1.3rem;
        border-radius: 4px;
        border: #ccc;
        padding: 10px 17px;
        color: #fff;
    }
    .reset {
        border: 1px solid #d5d5d5;
        margin-right: 17px;
        color:#555;
    }
    .submit {
        background-color: #06a406;
    }
    .alert {
        padding: 10px 7px;
    }
    .alert.alert-danger {
        color: red;
    }
    .toast {
        position: absolute;
        top: 0;
        left: 0;
        padding: 10px 17px;
        width: 100%;
        font-size: 1.7rem;
        color: #fff;
        background-color: green;
        text-align: center;
    }
    .hidden {
        display: none;
    }
    label[for=feedback] {
        position: relative;
    }
    #feedback-length {
        color: #a1a0a0;
        position: absolute;
        bottom: 0;
        right: 0;
    }
</style>
@endsection

@section('content')
    @if(!is_null(session('success')))
        <div class="toast">{{ session('success') }}</div>
    @endif

<form id="form-feedback" action="{{ route('feedback.store') }}" method="POST">
    @csrf
    <div>
        <label for="full_name" >П.І.Б:</label>
        <input data-type="string" data-validated="0" id="full_name" name="full_name" required type="text" maxlength="57" value="{{ old('full_name') }}"/>
        @error('full_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="phone">Телефон:</label>
        <input data-type="phone" data-mask="+38(000)-(000)-(00)-(00)" data-validated="0" id="phone" placeholder="+38(099)-(111)-(22)-(22)" name="phone" type="text" required value="{{ old('phone') }}" maxlength="25"/>
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="city_id" >Місто:</label>
        <select data-type="number" data-validated="0" id="city_id" name="city_id" required value="{{ old('city_id') }}">
            <option value="0"></option>
            @foreach($cities as $city)
                @if(old('city_id') == $city->id)
                    <option selected value="{{ $city->id }}">{{ $city->city }}</option>
                @else
                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                @endif
            @endforeach
        </select>
        @error('city_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="feedback" >Відгук:<span id="feedback-length">Символів: <span>0</span></span></label>
        <textarea data-type="string" data-value="1" rows="5" data-validated="0" id="feedback" name="feedback" required value="{{ old('feedback') }}">
            {{ old('feedback') }}
        </textarea>
        @error('feedback')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="control">
        <input name="btn-reset" class="reset" type="button" value="Очистити"/>
        <input name="btn-submit" class="submit" type="submit" value="Додата" />
    </div>
</form>
@endsection

@section('footer')
    <script type="text/javascript">
        // +38-(099)-(222)-(22)-(22)
        (function(main) {
            let fullName = document.getElementById('full_name');
            let phone = document.getElementById('phone');
            let city = document.getElementById('city_id');
            let feedback = document.getElementById('feedback');
            let feedbackLength = document.getElementById('feedback-length');
            let btnReset = document.querySelector('input[name=btn-reset]');
            let formFeedback = document.querySelector('form#form-feedback');
            let toast = document.querySelector('.toast');

            // add Event validation



            btnReset.onclick = function() {
                formFeedback.reset();
            }
            // full name
            fullName.onkeydown = function (e) {
                const fullName = /[a-zA-Zа-яА-ЯІіЄєЇїґҐ\s]/mi;

                if (!fullName.test(e.key)) {
                    return false;
                }
            }

            // phone
            phone.onkeydown = function (e) {
                const fullName = /[0-9\(\-\)\+]/mi;

                if (!fullName.test(e.key)) {
                    return false;
                }
            }

            formFeedback.onsubmit = function () {
                // return false;
            }
            // full name

            // size feedback
            feedback.onkeydown = function () {
                feedbackLength.querySelector('span').innerText = this.value.length;
            }

            if (toast) {
                setTimeout(function() {
                    toast.classList.add('hidden');
                }, 2000);
            }
        })(window);
        // //'phone' => 'required|regex:/^\+38[\-\(\)\d]+/im|min:18',
    </script>
@endsection

