
<div id="about" class="about section-wrapper py-md-5rem py-3rem mt-5rem mt-md-5rem">
    <div id="particles-js" class="particles-js"></div>
    <div class="container d-flex items-center">
        <div class="section about-header pe-md-3 pe-0">
            <div class="row mb-2">
                <div class="col-11 col-md-12 col-lg-10">
                    <h3 class="brand-slogan">I'm <span>Driss</span> <span>Boumlik</span></h3>
                </div>
            </div>
            <div class="row">
                    <div class="col-12">
                        <div class="welcome-message">
                            <div class="welcome-message-wrapper tc-black-almost">
                                <div class="txt">
                                    <p>I code, blog, speak, teach, mentor ... and other stuff usually not in the same order.</p>
                                    <p>I like to build & share things that add value or make positive impact.</p>
                                    <p>Find more <a href="/about">about me</a>.</p>
                                </div>
                            </div>
                        </div>
                        <div class="social-icons mt-3">
                            @include('addons.social-links', ['socialLinks' => $socialLinks])
                        </div>
                    </div>
                </div>
        </div>
        <div class="section about-code">
            <div class="code-wrapper">
                <div class="ide-wrapper d-flex">
                    <div class="ide-section editor-wrapper d-flex hidden-small">
                        <div class="header">
                            <div class="txt bold text-capitalize">editor</div>
                            <div class="btn-actions">
                                <button class="btn-action btn-edit text-capitalize tc-blue-bg">edit</button>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body-container"></div>
                        </div>
                    </div>
                    <div class="ide-section output-wrapper d-flex hidden-small">
                        <div class="header">
                            <div class="txt bold text-capitalize">output</div>
                            <div class="btn-actions">
                                <button class="btn-action btn-run text-capitalize tc-green-bg">run</button>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body-container">
                                <div class="body-loading d-none">
                                    <div class="loader"></div>
                                </div>
                                <div class="lines"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
