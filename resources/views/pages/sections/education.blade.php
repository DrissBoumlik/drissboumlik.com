<div class="section education" id="education">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">education</h1>
        </div>
        <div class="row">
            <div class="timeline reversed">
                @foreach ($education->items as $educationItem)
                    <div class="section left graduate rotated">
                        <div class="content">
                            <h2 class="where uppercase">{{  $educationItem->school }}</h2>
                            <h2 class="function">{{  $educationItem->grade }}</h2>
                            <span><i class="far fa-calendar-alt"></i> {{  $educationItem->time }}</span>
                            <hr class="mgtb-10">
                            <p>{{  $educationItem->field }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
