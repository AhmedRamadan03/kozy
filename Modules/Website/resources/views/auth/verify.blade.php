@extends('website::layouts.master')

@section('title')
    {{ __('front.verify') }}
@endsection
@section('css')
    <style>
        .number-code {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .code-input {
            width: 50px;
            height: 50px;
            border: 1px solid var(--primary) !important;
            border-radius: 5px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: var(--primary) !important;
        }
    </style>
@endsection
@section('content')
    <div class="container pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6  ">
                <div class="card shadow p-3 border-0">
                    <div class="">
                        <b class="fs-3 text-dark">{{ __('front.recive_code') }}</b>
                        <p class="pt-2">
                            {{ __('front.please_enter_the_code_was_sent_to') }}
                            {{-- <b></b> --}}
                        </p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('verify') }}">
                            @csrf


                            <div class="form-group row">

                                <div class="col-md-12">
                                        <div class="number-code">
                                            <input name='' class='code-input' required />
                                            <input name='' class='code-input' required />
                                            <input name='' class='code-input' required />
                                            <input name='' class='code-input' required />
                                            <input type="hidden" name="verification_key"  id="verification_key">

                                        </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0 pt-5">
                                <div class="">
                                    <button type="submit" class="btn btn--custom w3-block">
                                        {{ __('front.verify') }}
                                    </button>


                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
@section('js')
<script>
    const inputElements = [...document.querySelectorAll('input.code-input')]

inputElements.forEach((ele,index)=>{
  ele.addEventListener('keydown',(e)=>{
    // if the keycode is backspace & the current field is empty
    // focus the input before the current. Then the event happens
    // which will clear the "before" input box.
    if(e.keyCode === 8 && e.target.value==='') inputElements[Math.max(0,index-1)].focus()
  })
  ele.addEventListener('input',(e)=>{
    // take the first character of the input
    // this actually breaks if you input an emoji like 👨‍👩‍👧‍👦....
    // but I'm willing to overlook insane security code practices.
    const [first,...rest] = e.target.value
    e.target.value = first ?? '' // first will be undefined when backspace was entered, so set the input to ""
    const lastInputBox = index===inputElements.length-1
    const didInsertContent = first!==undefined
    if(didInsertContent && !lastInputBox) {
      // continue to input the rest of the string
      inputElements[index+1].focus()
      inputElements[index+1].value = rest.join('')
      inputElements[index+1].dispatchEvent(new Event('input'))
    }

    // set the verification code
    document.getElementById('verification_key').value = inputElements.map(({value})=>value).join('');
  })
})


// mini example on how to pull the data on submit of the form
function onSubmit(e){
  e.preventDefault()
  const code = inputElements.map(({value})=>value).join('')
  console.log(code)
}
</script>
@endsection
