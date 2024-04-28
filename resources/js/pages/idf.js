import $ from 'jquery';
import { gsap } from 'gsap'
import SplitType from 'split-type'

$(function () {
    try {
        // const ourText = new SplitType('#profile-name', { types: 'words,chars' })
        // gsap.fromTo(
        //     ourText.chars,
        //     {
        //         y: 100,
        //         opacity: 0
        //     },
        //     {
        //         y: 0,
        //         opacity: 1,
        //         stagger: 0.05,
        //         duration: 1.3,
        //         ease: 'power4.out',
        //     }
        // )

        const ourText = new SplitType('#greeting', { types: 'words,chars' })
        gsap.fromTo(
            ourText.chars,
            {
                // y: 100,
                scale: 2.5,
                opacity: 0
            },
            {
                // y: 0,
                scale: 1,
                opacity: 1,
                stagger: 0.05,
                duration: 1.3,
                ease: 'power4.out',
            }
        )
    } catch (error) {
        throw error;
        // console.log(error);
    }
});
