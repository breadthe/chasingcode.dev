<template>
  <div :class="replies.length || boosts.length || favorites.length ? 'my-4 flex flex-col gap-4' : ''">
    <div v-if="replies.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Replies</h6>

      <div class="flex flex-col gap-2">
        <div v-for="reply in replies" :key="reply.url" class="p-2 border-2 border-mastodon-purple rounded">
          <a :href="reply.author.url" class="flex gap-2 items-center text-base text-mastodon-purple font-bold group" target="_blank">
            <img :src="reply.author.photo" :alt="reply.author.name" class="w-16 rounded-lg">

            <div class="flex flex-col">
              <span class="font-normal group-hover:text-mastodon-purple group-hover:underline">{{ reply.author.name }}</span>
              <span class="text-sm text-gray-600 font-light">{{ authorUrlToMastodonUrl(reply.author.url) }}</span>
            </div>
          </a>

          <div class="mt-2 text-gray-900 text-sm font-light">
            <p class="text-black">{{ reply.content.text }}</p>

            <a :href="reply.url" target="_blank" class="block -mt-4 text-right text-mastodon-purple hover:text-mastodon-purple hover:underline">Reply</a>
          </div>
        </div>
      </div>
    </div>

    <div v-if="boosts.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Boosted</h6>

      <div class="flex flex-wrap gap-2">
        <a v-for="boost in boosts" :key="boost.url" :href="boost.author.url" target="_blank">
          <img :src="boost.author.photo" :alt="boost.author.name" class="w-16 rounded-lg">
        </a>
      </div>
    </div>

    <div v-if="favorites.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Favorited</h6>

      <div class="flex flex-wrap gap-2">
        <a v-for="favorite in favorites" :key="favorite.url" :href="favorite.author.url" target="_blank">
          <img :src="favorite.author.photo" :alt="favorite.author.name" class="w-16 rounded-lg">
        </a>
      </div>
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
          // https://webmention.io/api/mentions.jf2?target=https://yourblog.com/blog/blog-post-slug/&per-page=100&page=0}
          webmentionIoUrl: 'https://webmention.io/api/mentions.jf2',
          siteUrl: 'https://chasingcode.dev',
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

        if (mentions.length) {
          this.link = mentions
              // find mentions that contain my Mastodon URL
              .filter((m) => m.url.startsWith('https://indieweb.social/@brbcoding'))
              // take the part before the hash
              .map(({ url }) => url.split('#')[0])
              // take the first one
              .shift();

          // use the wm-property to make lists of favourites, boosts & replies
          this.favorites = mentions.filter((m) => m['wm-property'] === 'like-of');
          this.boosts = mentions.filter((m) => m['wm-property'] === 'repost-of');
          this.replies = mentions.filter((m) => m['wm-property'] === 'in-reply-to');
        }
      },
      async getMentions(pageUrl) {
        let mentions = [];
        let page = 0;
        const perPage = 100;

        while (true) {
          const results = await fetch(
              `${this.webmentionIoUrl}?target=${this.siteUrl}${pageUrl}&per-page=${perPage}&page=${page}`
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
