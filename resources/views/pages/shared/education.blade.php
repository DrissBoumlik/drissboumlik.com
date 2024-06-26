<div class="py-5" id="education">
    <div class="section education">
        <div class="container">
            @include('components.headline', ['headline' => 'education'])
            <div class="row">
                <div class="col-12">
                    <div class="timeline">
                        @foreach ($education->data as $educationItem)
                            <div class="section left graduate rotated">
                                <div class="content">
                                    <h2 class="where text-uppercase">{{  $educationItem->school }}</h2>
                                    <h2 class="function">{{  $educationItem->grade }}</h2>
                                    <span><i class="fa-solid fa-calendar-days"></i> {{  $educationItem->time }}</span>
                                    <hr class="my-2">
                                    <p>{{  $educationItem->field }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
