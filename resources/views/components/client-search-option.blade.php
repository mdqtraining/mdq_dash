<div class='media align-items-center mw-250'>
    <div class='position-relative'><img src='{{ $user->image_url }}' class='mr-2 taskEmployeeImg rounded-circle' style="border: 1.5px solid #3ec9d6;">
    </div>
    <div class='media-body'>
        <h5 class='mb-0 f-13'>{{ ucfirst($user->name) }}</h5>
        <p class='my-0 f-11 text-dark-grey'>{{ $user->email }}</p>
        <p class='my-0 f-11 text-dark-grey'>
            {{ !is_null($user->clientDetails) ? mb_ucwords($user->clientDetails->company_name) : ' ' }}</p>
    </div>
</div>
