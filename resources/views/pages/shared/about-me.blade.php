
<div id="about" class="about section-wrapper md:py-20 py-12 lg:mt-20 mt-0">
    <div id="particles-js" class="particles-js"></div>
    <div class="container flex items-center">
        <div class="section about-header pe-0 md:pe-4">
            <div class="row mb-2">
                <div class="w-full md:w-11/12 lg:w-10/12">
                    <h3 class="brand-slogan">I'm <span>Driss</span> <span>Boumlik</span></h3>
                </div>
            </div>
            <div class="row">
                    <div class="w-full">
                        <div class="welcome-message">
                            <div class="welcome-message-wrapper tc-black-almost">
                                <div class="txt">
                                    <p>I code, blog, speak, teach, mentor ... and other stuff usually not in the same order.</p>
                                    <p>I like to build & share things that add value or make positive impact.</p>
                                    <p>Find more <a href="/about">about me</a>.</p>
                                </div>
                            </div>
                        </div>
                        <div class="social-icons mt-4">
                            @include('addons.social-links', ['socialLinks' => $socialLinks])
                        </div>
                    </div>
                </div>
        </div>
        <div class="section about-code">
            <div class="code-wrapper">
                <div class="ide-wrapper">
                    <div class="ide-section editor-wrapper hidden-small">
                        <div class="header">
                            <div class="txt bold capitalize">editor</div>
                            <div class="btn-actions">
                                <button class="btn-action btn-edit capitalize tc-blue-bg">edit</button>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body-container"></div>
                        </div>
                    </div>
                    <div class="ide-section output-wrapper hidden-small">
                        <div class="header">
                            <div class="txt bold capitalize">output</div>
                            <div class="btn-actions">
                                <button class="btn-action btn-run capitalize tc-green-bg">run</button>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body-container">
                                <div class="body-loading hidden">
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
