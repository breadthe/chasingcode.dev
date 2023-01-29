<template>
  <div class="my-4 sm:my-8 p-2 sm:p-4 bg-gray-100 shadow rounded">
    <div v-if="replies.length">
      <h6 class="text-xl text-mastodon-purple font-bold border-b border-mastodon-purple">Mastodon Replies</h6>

      <div class="flex flex-col gap-4">
        <div v-for="reply in replies" :key="reply.url">
          <a :href="reply.author.url" class="flex gap-2 items-center text-base text-mastodon-purple font-bold" target="_blank">
            <img :src="reply.author.photo" :alt="reply.author.name" class="w-16 rounded-lg">

            <div class="flex flex-col">
              <span class="font-normal">{{ reply.author.name }}</span>
              <span class="text-sm text-gray-600 font-light">{{ authorUrlToMastodonUrl(reply.author.url) }}</span>
            </div>
          </a>
          <a :href="reply.url" class="mt-2 text-gray-900 hover:text-black text-sm font-light" target="_blank">
            {{ reply.content.text }}
          </a>
        </div>
      </div>
    </div>
    <div v-else>
      <p class="text-gray-600 text-lg">No replies yet.</p>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        pageUrl: {
            type: String,
            required: true,
            default: '/blog',
        }
    },
    data() {
        return {
          // webmentionIoUrl: `https://webmention.io/api/mentions.jf2?target=${url}&per-page=${perPage}&page=${page}`,
          webmentionIoUrl: 'https://webmention.io/api/mentions.jf2',
          webmentionIoToken: 'XtXA3XxJfC6WK6sD2-oR-A',
          domain: 'chasingcode.dev',
          link: '',
          favorites: [],
          boosts: [],
          replies: [],
        };
    },
    computed: {

    },
    methods: {
      async loadWebmentions() {
        let mentions = await this.getMentions(this.pageUrl);
        console.log(this.pageUrl)
        console.log(mentions)

        if (mentions.length) {
          mentions = mentions.filter(m => m['wm-target'] === this.pageUrl);

          this.link = mentions
              // find mentions that contain my Mastodon URL
              .filter((m) => m.url.startsWith('https://indieweb.social/@brbcoding'))
              // take the part before the hash
              .map(({ url }) => url.split('#')[0])
              // take the first one
              .shift();
          console.log(mentions)

          // use the wm-property to make lists of favourites, boosts & replies
          this.favorites = mentions.filter((m) => m['wm-property'] === 'like-of');
          this.boosts = mentions.filter((m) => m['wm-property'] === 'repost-of');
          this.replies = mentions.filter((m) => m['wm-property'] === 'in-reply-to');
        }
      },
      async getMentions(url) {
        let mentions = [];
        let page = 0;
        let perPage = 100;

        while (true) {
          const results = await fetch(
              `${this.webmentionIoUrl}?domain=${this.domain}&token=${this.webmentionIoToken}`
          ).then((r) => r.json());

          mentions = mentions.concat(results.children);

          if (results.children.length < perPage) {
            break;
          }

          page++;
        }

        return mentions.sort((a, b) => ((a.published || a['wm-received']) < (b.published || b['wm-received']) ? -1 : 1));
      },

      // Transforms "https://mastodon.social/@authorname" to "@authorname@mastodon.social"
      authorUrlToMastodonUrl(url) {
        const parts = url.split('/');
        return `${parts[3]}@${parts[2]}`;
      },
    },
  created() {
      this.loadWebmentions();
  },
};
</script>

<style lang="scss" scoped>
</style>
