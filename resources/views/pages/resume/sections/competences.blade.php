<div class="py-5" id="competences">
    <div class="section competences">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">competences</h1>
                </div>
            </div>
            <div class="row">
                @foreach ($competences->techs as $key => $tech)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $tech->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $tech->value }}%" aria-label="{{ $tech->name }}"
                                role="progressbar" aria-valuenow="{{ $tech->value }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar-text">
                                    <span>{{ $tech->name }}</span>
                                    <span class="mx-1">-</span>
                                    <span class="progress-value d-inline-block">{{ $tech->value }}</span>
                                    <span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="section languages mt-5">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">languages</h1>
                </div>
            </div>
            <div class="row">
                @foreach ($competences->langs as $key => $lang)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $lang->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $lang->value }}%"
                                role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar-text">
                                    <span>{{ $lang->name }}</span>
                                    <span class="mx-1">-</span>
                                    <span class="progress-value d-inline-block">{{ $lang->value }}</span>
                                    <span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="section add-skills mt-5">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">additionnel skills</h1>
                </div>
            </div>
            <div class="row">
                @foreach ($competences->addSkills as $key => $addSkill)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $addSkill->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $addSkill->value }}%"
                                role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar-text">
                                    <span>{{ $addSkill->name }}</span>
                                    <span class="mx-1">-</span>
                                    <span class="progress-value d-inline-block">{{ $addSkill->value }}</span>
                                    <span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
