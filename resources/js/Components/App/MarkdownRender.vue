<script setup>
import MarkdownIt from "markdown-it";
import MarkdownItAbbr from 'markdown-it-abbr';
import MarkdownItAnchor from "markdown-it-anchor";
import MarkdownItFootnote from "markdown-it-footnote";
import MarkdownItHighlightjs from "markdown-it-highlightjs";
import MarkdownItSub from "markdown-it-sub";
import MarkdownItSup from "markdown-it-sup";
import MarkdownItTasklists from "markdown-it-task-lists";
import MarkdownItTOC from "markdown-it-toc-done-right";

const markdown = new MarkdownIt()
    .use(MarkdownItAbbr)
    .use(MarkdownItAnchor)
    .use(MarkdownItFootnote)
    .use(MarkdownItHighlightjs)
    .use(MarkdownItSub)
    .use(MarkdownItSup)
    .use(MarkdownItTasklists)
    .use(MarkdownItTOC);

const props = defineProps({
  source: {
    type: String,
    default: ""
  }
});
</script>


<template>
  <div id="markdown" v-html="markdown.render(source)" />
</template>

<style lang="scss">
#markdown {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
  color: #333;

  h1, h2, h3, h4, h5, h6 {
    margin: 1.5rem 0 1rem;
    font-weight: bold;
    line-height: 1.2;
  }

  h1 { font-size: 2rem; }
  h2 { font-size: 1.75rem; }
  h3 { font-size: 1.5rem; }
  h4 { font-size: 1.25rem; }
  h5 { font-size: 1rem; }
  h6 { font-size: 0.875rem; }

  p {
    margin: 0 0 1rem;
  }

  a {
    color: #007BFF;
    text-decoration: none;
    &:hover {
      text-decoration: underline;
    }
  }

  ul, ol {
    padding-left: 1.5rem;
    margin: 0 0 1rem;
  }

  ul {
    list-style-type: disc;
  }

  ol {
    list-style-type: decimal;
  }

  li {
    margin: 0.5rem 0;
    line-height: 1.4;
  }

  blockquote {
    margin: 1.5rem 0;
    padding: 0.75rem 1.5rem;
    background-color: #f9f9f9;
    border-left: 5px solid #ccc;
    font-style: italic;
    color: #555;
  }

  code {
    background-color: #f5f5f5;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
  }

  pre {
    background-color: #f5f5f5;
    padding: 1rem;
    border-radius: 5px;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    code {
      background: none;
      padding: 0;
    }
  }

  hr {
    border: 0;
    height: 1px;
    background: #ddd;
    margin: 2rem 0;
  }

  img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    th, td {
      padding: 0.75rem;
      text-align: left;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f5f5f5;
      font-weight: bold;
    }
  }

  /* Footnotes */
  sup {
    font-size: 0.8rem;
  }

  /* Task lists */
  input[type="checkbox"] {
    margin-right: 0.5rem;
  }
}

</style>

