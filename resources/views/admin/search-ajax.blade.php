
@forelse ($search as $data)

@if ($data->sr_no)
<li class="search-list">
    <a href="{{route('admin_case_details',[$data->id])}}">
        <div class="row xy-center">
            <div class="col-md-2 text-center">
                <img class="search-img-circle" id="imagePreview"
                    src="{{ asset($data->getuser->getUserDetails->image) }}"
                    alt="search picture">
            </div>
            <div class="col-md-10">
                <p class="text-black fw-bold mb-0 mt-1"> Sr # {{$data->sr_no}}, Case-Type # {{$data->getCaseLaw->title}}</p>
            </div>
        </div>
    </a>
</li>
@else
<li class="search-list">
    @if ($data->getUser->user_type == "customer")
        <a href="{{route('admin_clients_details',[$data->getUser->id])}}">
    @else
        <a href="{{route('admin_attornies_details',[$data->getUser->id])}}">
    @endif
        <div class="row xy-center">
            <div class="col-md-2 text-center">
                <img class="search-img-circle" id="imagePreview"
                    src="{{ asset($data->image) }}"
                    alt="search picture">
            </div>
            <div class="col-md-10">
                <p class="text-black fw-bold mb-0 mt-1">{{$data->first_name}} {{$data->last_name}} ( {{ucfirst($data->getUser->user_type == 'customer' ? 'customer' : $data->getUser->user_type )}} )</p>
            </div>
        </div>
    </a>
</li>
@endif

@empty
    <li class="search-list">
        <a href="javascript:void()">
            <div class="row xy-center">
                <div class="col-md-10">
                    <p class="text-black fw-bold mb-0 mt-1"> No data found kindly try any other keyword. </p>
                </div>
            </div>
        </a>
    </li>
@endforelse

