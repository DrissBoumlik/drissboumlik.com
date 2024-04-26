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
                    <div class="col-md-8 offset-md-2">
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
                                <img src="{{ asset('/assets/img/me/circle-256.png') }}" alt="Profile Image"
                                    width="100" height="100">
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
                <div class="col-md-8 offset-md-2">
                    <h2 class="text-center font-weight-bolder page-content-headline"
                    >Hi Yulia & Hiring Team</h2>
                    <h3>Who am I ?</h3>
                    <p>I'm <a href="/about" target="_blank">Driss Boumlik</a>, 34 years old, a developer from Sale, Morocco (near Rabat).
                        I like to build & share things that add value or make positive impact.
                        checkout our <a href="/community" target="_blank">community</a>.
                    <p>
                        I currently work a full time job, and not that actively searching for a job.
                        However, when I saw
                        <a href="https://www.interaction-design.org/about/careers/senior-php-laravel-developer" target="_blank">this job posting</a>
                        and specially the video on the <a href="https://www.interaction-design.org/about/careers/how-to-apply">how to apply page</a>
                        I had to apply since this sounds like a dream job and a once in a lifetime opportunity.
                        That being said, let's get to my story and why I think we are a great fit for each other.
                    </p>

                    <h3>My story</h3>
                    <p>
                        I started my journey in programming back at the university where I learned Algorithmic, C, Assembly, Java & C# ... .
                        I learned HTML & CSS later on my own by building a template and integrating it in WordPress.<br/>
                        After my graduation I had an experience as a trainer, I taught kids the basics of programming using
                        Lego EV3 mindstorms & Scratch, by the way I was invited to talk about this a year ago, you can
                        watch the recording
                        <a href="https://youtu.be/EpV5GA-kPos?t=1303" target="_blank">video</a>.<br/>
                        I started working as a contractor afterward with few companies using php/laravel & WordPress, where I learned so much.
                        and I decided to get a full time job and I did around the end of 2019, and after 4,5 months,
                        corona kicked in and the world switched to work remotely, and since then, we never went back to working
                        onsite except for an optional day per week.
                        <br/><span style="color: red">Not finished</span>
                    </p>

                    <h3 id="why-me">Why me ?</h3>
                    <p>
                        I am the go-to php/laravel guy at my current job, don't have all the answers 😅
                        but I know pretty much how to find them.
                        I also love to experiment and discover new things to add value & make others developers lives better.
                        I like to improve the development environment.
                        Here is a little bit more about that:
                    </p>
                    <h4>Laravel & git</h4>
                    <p>
                        - I Suggested Laravel & git at my current job. An internal php framework & svn were used before,
                        It may sound wired, but I fell in love with laravel because of C#, C# has great developer experience,
                        and I saw the same thing in laravel eloquent & collections and how it was readable and friendly,
                        and how quick it is to just write some code and boom, you have a fullstack running application
                        with many things out of the box (authentication, permissions, templates ...).<br/>
                        Currently I'm trying to convince them to use docker and something else for the frontend side.
                    </p>
                    <h4>Automation</h4>
                    <p>
                        - I joined a team working on a project started 6 months before I came,
                        we were testing apis with <a href="https://www.postman.com/" target="_blank">postman</a>,
                        and most of the apis required us to be authenticated,
                        so you need to hit the login api, copy the token from the response and paste it in the headers of
                        the api you want to test. the problem is that you're testing and oops!!, you need to login again
                        because the token expires after 30 minutes, and our request to extend to token life was not accepted.
                        so I took some time to dig a little bit in postman documentation, and found that I can write some script
                        before and after sending a request.
                        so I wrote a script that hits the login api every 30 min and copies the token paste it in a variable shared for all apis,
                        so we can focus only on testing the apis.
                    </p>
                    <p>
                        - In my current job, we have few teams working on many projects (most of them are laravel based),
                        and we have an internal server where we deploy our client apps for testing.
                        but for our clients, the method to update the apps on their side is a bit different,
                        we should send a zip file containing the new changes made on the app code.
                        in order to do so, we use git to fetch the updated files since the last zip,
                        generate the sql files in case of new database migrations, and compile the js/css files in the public directory.
                        so I wrote a <a href="https://github.com/DrissBoumlik/patch-generator/blob/master/build.sh" target="_blank">bash script</a>
                        to automate the process.
                    </p>
                    <h4>Environment</h4>
                    <p>
                        - As developers, we use the terminal on a daily basis, and we have a few commands that we always use.
                        so I created a list of aliases to make it easy and quick to type these commands and not forgetting them
                        in the same time.
                        checkout <a href="https://github.com/DrissBoumlik/desktop-config/blob/master/terminal/cmder/user_aliases.cmd" target="_blank">cmder</a>
                        & <a href="https://github.com/DrissBoumlik/desktop-config/blob/master/terminal/zsh/.zshrc" target="_blank">bash</a> aliases.
                    </p>
                    <p>
                        - Another thing, since I work mostly on windows, and working on projects with different php versions,
                        I came up with a solution which allowed me to switch php versions on windows with one command.
                        you can read about it here :
                        <a href="https://drissboumlik.com/blog/switch-php-version-on-windows-with-one-command" target="_blank">link</a>.
                    </p>

                    <h4>Community</h4>
                    <p>
                        At the end of 2020 I created a community with a goal in mind to help moroccan developers and build
                        a healthy community environment where we help each other,
                        and I achieved that, thanks to >= 1.6k members and these amazing
                        <a target="_blank" href="http://community.drissboumlik.com/p/contributors#contributors">contributors</a>.
                    </p>

                    <h4>Planning</h4>
                    <p>
                        I would like to share with you how I spend my time,
                        <a href="{{ asset('/assets/idf/calendar.png') }}" target="_blank">
                            <img src="{{ asset('/assets/idf/calendar.png') }}" class="img-fluid" alt="">
                        </a>
                    </p>

                    <h4>Funny stuff</h4>
                    <p>
                        - My colleagues always ask my this question:
                        "why do you use <a href="https://laravel.com/docs/11.x/collections#method-flatten" target="_blank">flatten</a>
                        collection method ?"<br/>
                        I mean, who doesn't love a method that smooths out complexity faster than coffee on a Monday morning?"
                    </p>
                    <p>
                        - I'm not an expert on css but I solved a few <a href="https://cssbattle.dev/player/drissboumlik" target="_blank">challenges</a> in
                        <a href="https://cssbattle.dev/" target="_blank">cssbattle.dev</a>, and my colleagues always make a joke
                        about how I don't know how to center a div (famous css joke !).
                    </p>

                    <h3>Stay updated</h3>
                    <ul>
                        <li>I follow many people & companies on X (Formerly Twitter).</li>
                        <li>I subscribe to a few people and repositories on GitHub to stay up to date.</li>
                        <li>I watch conferences recordings, so I can know new things like <a target="_blank" href="https://frankenphp.dev/">Franken Php</a>.</li>
                        <li>I follow a few YouTube steamers.</li>
                        <li>I listen to a few <a target="_blank" href="https://castbox.fm/cl/360626">podcasts</a>.</li>
                        <li>I use apps like <a target="_blank" href="https://feedly.com/">feedly</a>.</li>
                        <li>I open Reddit, but not that much.</li>
                    </ul>

                    <h3>Non-Hard Skills</h3>
                    <p>
                        - I do like to exchange, share, learn new things, different ways of thinking, have interesting & deep
                        conversations and challenge my opinions in order to argue & adapt.
                    </p>
                    <p>
                        - If am not in front of my laptop, I play soccer twice a week in reality, and everyday
                        <a target="_blank" href="https://rawg.io/@cartouche/games">virtually</a>,
                        otherwise I watch <a target="_blank" href="https://anilist.co/user/cartouche/animelist">anime</a> and tv
                        <a target="_blank" href="https://trakt.tv/users/cartouche01/progress">shows</a>,
                        listen to <a target="_blank" href="https://castbox.fm/cl/360626">podcasts</a> or read
                        <a target="_blank" href="https://www.goodreads.com/review/list/170245827-driss?view=covers">books</a>.
                    </p>

                    <h3>About the <a target="_blank" href="https://www.interaction-design.org/about/careers/how-to-apply"
                        class="text-decoration-underline">how to apply video</a></h3>
                    <p>
                        Let me tell you how I ended up watching the video 3 times.<br/>
                        When I visited the how to apply page, I pressed play to watch the video, and in the very first minute
                        I heard this:
                    </p>
                    <div class="report-actions highlight-box px-3 py-2">
                        <p class="m-0">
                            We <span class="fst-italic">live and breathe our values</span>, and they form the basis of our
                            <span class="fst-italic">work culture</span>.<br/>
                            What this means is that our values are not just nice words that we put onto our website.<br/>
                            They actually reflect and shape the way we behave.<br/>
                        </p>
                    </div>
                    <p>
                        the first thing that popped up in my mind was: "I want to work with these people !"
                    </p>
                    <p>
                        and then a question kicked in: "Do I really want to work with them ?, I think the answer is in
                        the rest of the video!", and watched the whole 17min and I felt like if I was setting with you guys
                        and talking to each other just like you said:
                    </p>
                    <div class="report-actions highlight-box px-3 py-2">
                        <p class="m-0">
                            The more our cultures and values resonate with you, the more likely you will love working with us!<br/>
                            So, please use this video as a sort of a conversational partner and continuously ask yourself,
                            how <span class="fst-italic">you</span> would fit into the culture.
                        </p>
                    </div>

                    <p>
                        With that been said, I think I would make a good fit, and I hope you <a href="#why-me">think</a> the same as well.
                    </p>

                    <h3>What the future holds</h3>
                    <p></p>

                    <hr class="my-5"/>
                    <p>
                        That's not all, there is more, but I hope I already convinced you enough to start a conversation.
                        I am looking forward to your response & feedback!
                    </p>
                </div>
            </div>


        </div>

    </div>


    <footer class="page-footer">
        <div class="container-fluid p-0 footer text-center">
            <div class="copy-right-wrapper container w-100 py-4">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-12 owner">
                        <p>Made with <span class="heart-icon"><i class="fa-solid fa-heart"></i></span> by <span class="bold">Driss Boumlik</span></p>
                    </div>
                </div>
            </div>

        </div>
    </footer>
@endsection
