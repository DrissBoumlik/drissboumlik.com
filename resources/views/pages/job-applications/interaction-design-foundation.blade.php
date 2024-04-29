@extends('layout.app')

@section('post-header-assets')
    @vite(['resources/sass/idf.sass', 'resources/js/pages/idf.js'])
@endsection


@section('content')

    <div id="about" class="about section-wrapper py-md-5rem py-3rem">
        <div class="section about-header">
            <div id="particles-js" class="particles-js"></div>
            <div class="container headline-wrapper">
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="profile-data">
                                <div class="profile-name" id="profile-name">Driss Boumlik</div>
                                <div class="profile-links d-flex">
                                    <div class="github profile-link"><a href="https://github.com/drissboumlik" target="_blank">
                                            <i class="fa-brands fa-github"></i> Github</a></div>
                                    <div class="twitter profile-link"><a href="https://twitter.com/drissboumlik" target="_blank">
                                            <i class="fa-brands fa-x-twitter"></i> Twitter</a></div>
                                </div>
                            </div>
                            <div class="profile-image">
                                <img src="assets/img/me/circle-256_2.png" alt="Profile Image"
                                    width="100" height="100" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="page-wide" class="page page-wide container-fluid py-5 px-2">

        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2 class="text-center font-weight-bolder page-content-headline">
                        <span id="greeting" class="d-block">Hi Yulia & Hiring Team 👋</span></h2>

                    <h3>TLDR;</h3> REMOVE
                    <div class="tldr">
                        <audio controls preload
                               class="w-100 audio-player" id="audio-player">
                            <source src="" type="audio/mp3">
                            Your browser does not support the audio tag.
                        </audio>
                    </div>

					<p style="margin-top: 2rem; color:red">
					THIS application  should be a response to : <br/>
					Write an application to us which includes a few paragraphs on why you want to put your heart, mind and hard work into this particular job.
					</p>

                    <h3>First things first ...</h3>
                    <p>According to the
                        <a href="https://www.interaction-design.org/about/careers/how-to-apply" target="_blank">video</a>
                        I confirm that :
                    </p>
                    <div class="report-actions highlight-box px-3 py-2">
                        <p class="m-0">
                            I want to help make a dent in the universe 🍀🍀🍀.</p>
                    </div>
                    <p>(Find more about this at the bottom of the page)</p>

                    <h3>Who am I ?</h3>
                    <p>I'm <a href="https://drissboumlik.com/about" target="_blank">Driss Boumlik</a>, 34 years old,
                        a developer from Sale, Morocco (near Rabat).
                        I like to build and share things that add value or make positive impact.
                        I love solving problems 🧠, helping beginner developers 💻 and ... more ツ.
                    </p>
                    <p>
                        I currently work a full time job, and not that actively searching for a job.
                        However, when I saw
                        <a href="https://www.interaction-design.org/about/careers/senior-php-laravel-developer" target="_blank">this job posting</a>
                        and especially the video on the <a href="https://www.interaction-design.org/about/careers/how-to-apply" target="_blank">how to apply page</a>
                        I had to apply since this sounds like a great opportunity.
                        That being said, let's get to my story and why I think we are a great fit for each other.
                    </p>

                    <h3>My story</h3>
                    <p>
                        I started my journey in programming back at the university where I learned Algorithmic, C, Assembly, Java and C#.
                        I learned HTML, CSS, Javascript and Bootstrap later on my own.<br/>
                        After my graduation I had 2 internships then I switched to full time trainer, as I had an amazing
                        experience teaching kids the basics of programming using
                        <a href="https://education.lego.com/en-us" target="_blank">Lego EV3 mindstorms</a> and
                        <a href="https://scratch.mit.edu/" target="_blank">Scratch</a>,
                        and a year ago, I was invited to talk about it, you can watch the recording <a href="https://youtu.be/EpV5GA-kPos?t=1303" target="_blank">video</a>.
                    </p>
                    <div class="img-container">
                        <figure>
                            <img src="assets/idf/coding-for-kids.jpg" class="img-fluid" alt="Lego EV3 Mindstorms Session">
                            <figcaption class="text-center mt-1">Lego EV3 Mindstorms Session.</figcaption>
                        </figure>
                   </div>
                    <p>
                        I started working as a freelance contractor afterward with few companies using PHP/Laravel and WordPress, where I learned so much,
                        then I decided to get a full time job and I did around the end of 2019,
                        which was a great experience because I learned to be a team player among other things,
                        after 4/5 months corona kicked in and the world switched to work remotely.
                    </p>

                    <h3 id="why-me">Why me ?</h3>
                    <p>
                        I am the go-to php/laravel guy at my current job, don't have all the answers 😅
                        but I know pretty much how to find them.
                        I also love to experiment and discover new things to add value and make others developers lives better.
                        I like to improve the development environment.
                        Here is a little bit more about that:
                    </p>
                    <ul>
                        <li> {{--Automation--}}
                            I joined a team working on a project started 6 months before I came,
                            I wrote a script which refreshes the auth token automatically,
                            so we can focus only on testing those apis, which helped the team.
                        </li>
                        <li> {{--Laravel & Git--}}
                            I Suggested Laravel and Git at my current job. An internal php framework and svn were used before.
                            Currently, I'm trying to convince them to use docker and something else for the frontend side.
                        </li>
                        <li> {{--Environment--}}
                            I created a list of bash
                            <a href="https://github.com/DrissBoumlik/desktop-config/blob/master/terminal/zsh/.zshrc" target="_blank">aliases</a>
                            which helped few team members, You can read about it
                            <a href="https://drissboumlik.com/blog/how-cmder-made-my-life-easier-part-2" target="_blank">here</a>.
                        </li>
                        <li>
                            Another thing, I work on projects with different php versions on windows,
                            I came up with a solution which allowed me to switch php versions on windows with one command.
                            you can read about it
                            <a href="https://drissboumlik.com/blog/switch-php-version-on-windows-with-one-command" target="_blank">here</a>.
                        </li>
                    </ul>

                    <h4>Contribution</h4>
                    <p>
                        I did some digging on the website and other IxDF links,
                        and I found the <a href="https://www.interaction-design.org/about" target="_blank">about</a> page
                        where you talk about your mission, which I really appreciate,
                        I also found that you have published some public packages
                        on <a target="_blank" href="https://github.com/InteractionDesignFoundation">github</a> and
                        <a target="_blank" href="https://packagist.org/users/IxDF/">packagist</a>, and I really liked it
                        because it means that not only you're providing the best expertise and quality content for learners
                        with affordable prices, but you're also creating what benefits the open source community,
                        and that gives me another reason to wanting to join you.
                    </p>
                    <h4>Community</h4>
                    <p>
                        The idea of contributing, sharing knowledge, helping others, adding value, all these things
                        pushed me to host many online & in-person workshops and create a
                        <a href="https://drissboumlik.com//community" target="_blank">community</a>
                        at the end of 2020 with a goal in mind to help moroccan developers and build
                        a healthy environment conducive to learning where we help each other,
                        and I achieved that, thanks to >= 1.6k members and especially these amazing
                        <a target="_blank" href="https://community.drissboumlik.com/p/contributors#contributors">contributors</a>.
                    </p>
                    <div class="img-container">
                        <figure>
                            <img src="assets/idf/workshops.jpg" class="img-fluid" alt="Web Development Workshop">
                            <figcaption class="text-center mt-1">Web Development Workshop.</figcaption>
                        </figure>
                    </div>


                    <h3>After work-hours</h3>
                    <p>
                        As you can see in my <a href="assets/idf/calendar.png" target="_blank">calendar</a>,
                        each day I have something to do:
                    </p>
                    <ul>
                        <li>I take a ride on my bike.</li>
                        <li>I read a book.</li>
                        <li>I spend some time on <a target="_blank" href="https://www.leetcode.com/">LeetCode</a>.</li>
                        <li>I host an event for the <a target="_blank" href="https://drissboumlik.com/community">community</a>.</li>
                        <li>I host a <a target="_blank" href="https://community.drissboumlik.com#mock-interview">mock interview</a>
                            (in case someone applied).</li>
                    </ul>

                    <h3>About the <a target="_blank" href="https://www.interaction-design.org/about/careers/how-to-apply"
                        class="text-decoration-underline">how to apply video</a></h3>
                    <p>
                        I started watching video, and in the very first minute
                        I heard this:
                    </p>
                    <div class="report-actions highlight-box px-3 py-2">
                        <p class="m-0">
                            We <span class="keyword">live and breathe our values</span>, and they form the
                            <span class="keyword">basis</span> of our
                            <span class="keyword">work culture</span>, What this means is that our values are
                            <span class="keyword">not just nice words</span> that we put onto our website,
                            They actually reflect and shape the way we <span class="keyword">behave</span>.<br/>
                        </p>
                    </div>
                    <p>
                        The first thing that popped up in my mind was: <span class="keyword-2">"I want to work with these people !"</span>,
						then a question kicked in: <span class="keyword-2">"Do I really want to ?, I think the answer is in
                        the rest of the video!"</span>, I ended up watching the video, twice, and I felt like if I was setting with you guys
                        and talking to each other just like you said:
                    </p>
                    <div class="report-actions highlight-box px-3 py-2">
                        <p class="m-0">
                            The more our cultures and values <span class="keyword">resonate</span> with you,
                            the more likely you will <span class="keyword">love working</span> with us!
                            So, please use this video as a sort of,
                            <span class="keyword">a conversational partner</span>
                            and <span class="keyword">continuously ask yourself</span>,
                            how you would fit into the culture.
                        </p>
                    </div>
                    <p>
                        <span class="keyword">"We always say that failure is an event, not an identity"</span>
                        and <span class="keyword">"fail forward"</span>
                        these words are spot on, and just hit me so hard, because I've dealt with many people, especially students and freshmen who failed in their first job
                        or had difficulties to cop with the industry challenges, and tried to help them and mentor them in a way to overcome
                        these obstacles.
                    </p>
                    <p>
                        So YES, I do believe in these core values, from
                        <span class="keyword">"A culture of short-term execution that enables long-term thinking"</span>
                        to the <span class="keyword">"culture of grit"</span>,
                    </p>
                    <p>
                        With that been said, I hope this answers the
                        <span class="keyword">"why you want to put your heart, mind and hard work into this particular job."</span>
                        and I hope you <a href="#why-me">think</a> I'm a good fit.
                    </p>

                    <hr class="my-5"/>
                    <p>
                        That's not all, there is more, but I hope I already convinced you enough to start a conversation.
                        I am looking forward to your response and feedback!
                    </p>
                </div>
            </div>


        </div>

    </div>

    <footer class="page-footer">
        <div class="container-fluid p-0 footer text-center">
            <div class="copy-right-wrapper container w-100 py-3">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-12 owner">
                        <p>Made with <span class="heart-icon"><i class="fa-solid fa-heart"></i></span> by <span class="bold">Driss Boumlik</span></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection
