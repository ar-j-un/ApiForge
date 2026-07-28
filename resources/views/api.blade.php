@extends('layouts.app')

@section('title', 'Api')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('api') }}">Api</a></li>
@endsection

@section('content')
<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-coreui-toggle="tab" href="#tab-api-1" role="tab">
            API Tab 1
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-coreui-toggle="tab" href="#tab-api-2" role="tab">
            API Tab 2
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab-api-1" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header"><strong>Api</strong></div>
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Api #1
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-coreui-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p id="accordion-text-1">
                                            <strong>First api is.</strong>
                                            https://example.com
                                        </p>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyAccordionText('accordion-text-1')">
                                            <svg class="icon me-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14">
                                                <path fill="currentColor" d="M384 96H96a32 32 0 0 0-32 32v320a32 32 0 0 0 32 32h288a32 32 0 0 0 32-32V128a32 32 0 0 0-32-32Zm0 352H96V128h288Z"/>
                                                <path fill="currentColor" d="M128 32h288a32 32 0 0 1 32 32v288h-32V64H128Z"/>
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Api #2
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-coreui-parent="#accordionExample">
                                    <div class="accordion-body">
                                        https://example.com
                                    </div>
                                    <h5 class="ms-2">
                                        Api
                                        <span class="badge text-bg-primary">status</span>
                                    </h5>
                                    <span class="badge text-bg-success ms-3 mb-3">Completed</span>
                                    {{-- <span class="badge text-bg-warning">Pending</span>
                                    <span class="badge text-bg-danger">Failed</span> --}}
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Api #3
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-coreui-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>Third Api </strong>
                                        is<code>  https://example.com</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Api</strong>
                        <span class="small ms-1">Flush</span>
                    </div>
                    <div class="col-12">
                        <p class="text-body-secondary small mb-2 ms-3">
                            Add <code>.com </code> at the ending of the url
                        </p>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Api #1
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="flush-collapseOne" aria-labelledby="flush-headingOne" data-coreui-parent="#accordionFlushExample">
                                    <div class="accordion-body">https://example
                                        <p class="placeholder-glow mt-2 mb-0">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Api #2
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="flush-collapseTwo" aria-labelledby="flush-headingTwo" data-coreui-parent="#accordionFlushExample">
                                    <div class="accordion-body">https://example</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab-api-2" role="tabpanel">
        <div id="apiTypesSpinner" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

    <div id="apiTypesContent" class="d-none">

        <button class="btn btn-primary mt-3 mb-3"
                data-coreui-toggle="modal"
                data-coreui-target="#myModal">
            Apis
        </button>

        <ul class="list-group">
            <li class="list-group-item">Public APIs</li>
            <li class="list-group-item">Partner APIs</li>
            <li class="list-group-item">Internal APIs</li>
            <li class="list-group-item">Composite APIs</li>
        </ul>

        <div class="d-flex flex-column gap-2 align-items-start">
            <button type="button"
                id="hintButton"
                class="btn btn-primary mt-3"
                data-coreui-toggle="popover"
                data-coreui-title="Api"
                data-coreui-content="Application Programming Interface">
                    Hint
            </button>

            <button type="button"
                    class="btn btn-primary mt-3"
                    data-coreui-toggle="tooltip"
                    title="You found easter egg">

                Hover here

            </button>
        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
               Api Types
            </div>

            <div class="modal-body">
                REST<br>SOAP<br>GraphQL<br>gRPC
            </div>

        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="apiHintToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Api</strong>
            <small class="text-body-secondary">just now</small>
            <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            you clicked hint
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function copyAccordionText(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Api copied');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const apiTypesTab = document.querySelector('[href="#tab-api-2"]');
    const spinner = document.getElementById('apiTypesSpinner');
    const content = document.getElementById('apiTypesContent');

    apiTypesTab.addEventListener('shown.coreui.tab', () => {
        spinner.classList.remove('d-none');
        content.classList.add('d-none');

        setTimeout(() => {
            spinner.classList.add('d-none');
            content.classList.remove('d-none');
        }, 1000);
    });

    const hintButton = document.getElementById('hintButton');
        const toastEl = document.getElementById('apiHintToast');
        const toast = new coreui.Toast(toastEl);

        hintButton.addEventListener('click', () => {
            toast.show();
        });
});
</script>
@endpush