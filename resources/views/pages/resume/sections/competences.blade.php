<div class="py-5" id="competences">
    <div class="competences">
        <div class="container">
            @include('components.headline', ['headline' => $competences->techs->header])
            <div class="row">
                @foreach ($competences->techs->items as $key => $tech)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $tech->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $tech->value }}%"
                                title="{{ $tech->name }}" aria-label="{{ $tech->name }}" aria-labelledby="{{ $tech->name }}"
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
    <div class="languages mt-5">
        <div class="container">
            @include('components.headline', ['headline' => $competences->langs->header])
            <div class="row">
                @foreach ($competences->langs->items as $key => $lang)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $lang->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $lang->value }}%"
                                title="{{ $lang->name }}" aria-label="{{ $lang->name }}" aria-labelledby="{{ $lang->name }}"
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
    <div class="add-skills mt-5">
        <div class="container">
            @include('components.headline', ['headline' => $competences->addSkills->header])
            <div class="row">
                @foreach ($competences->addSkills->items as $key => $addSkill)
                    <div class="col-md-6 col-12">
                        <div class="progress mb-4">
                            <div id="{{ $addSkill->id }}" class="progress-bar delay padding-left"
                                style="width: {{ $addSkill->value }}%"
                                title="{{ $addSkill->name }}" aria-label="{{ $addSkill->name }}" aria-labelledby="{{ $addSkill->name }}"
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
