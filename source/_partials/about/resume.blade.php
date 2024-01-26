<article class="flex flex-col p-4 sm:p-6 bg-white rounded">
    <h2>Professional work</h2>

    <p>I've worked in a variety of <strong>industries</strong> throughout my career. Here are some of the most recent.</p>

    <x-resume-item
            title="Knowledge management SaaS"
            description="Built, maintained, and integrated features such as SCIM, payments, search, and many others, for a SaaS app that helps companies manage their internal knowledge base."
            :tech="['Laravel' => '/blog/categories/Laravel', 'React' => null]"
    />

    <x-resume-item
            title="Parking booking SaaS"
            description="Wrote API endpoints for running parameterized reporting in a serverless AWS Lambda environment."
            :tech="['Node.js' => null, 'AWS' => null]"
    />

    <x-resume-item
            title="Transportation & freight"
            description="Full lifecycle app for receiving cargo shipping orders, processing pickups and deliveries, and generating bills of lading. Internal/external APIs connecting various systems."
            :tech="['Laravel' => '/blog/categories/Laravel', 'Vue.js' => '/blog/categories/VueJS', 'TailwindCSS' => '/blog/categories/TailwindCSS', 'MySQL' => '/blog/categories/MySQL', 'AWS' => null]"
    />

    <x-resume-item
            title="Nocode SaaS"
            description="Front-end UI work for the SPA part of an emerging lowcode/nocode SaaS app running in a serverless environment. Implemented secure document handling in AWS, and image manipulation."
            :tech="['Ember.js' => null, 'AWS' => null]"
    />

    <x-resume-item
            title="Online student testing"
            description="Built new front- and back-end modules and extended functionality for a web-based K12 testing platform."
            :tech="['PHP' => '/blog/categories/PHP', 'MySQL' => '/blog/categories/MySQL', 'jQuery' => null]"
    />

    <x-resume-item
            title="eCommerce"
            description="Built a brand-new website for a well-known local retailer. First year sales improved 90% compared to the old website. Made many enhancements to the site, leading to increasing sales year over year."
            :tech="['PHP' => '/blog/categories/PHP', 'MySQL' => '/blog/categories/MySQL', 'jQuery' => null]"
    />
</article>