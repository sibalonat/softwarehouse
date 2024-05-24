<script setup>
import { computed, inject, onBeforeMount, ref } from "vue";
import { useNavigationStore } from "@/Stores/NavigationStore";
import { storeToRefs } from "pinia";
// pinia
const menu = useNavigationStore();
const { accordion } = storeToRefs(menu);

// properties
const index = ref(null)

// computed
const visible = computed(() => {
    return index.value == accordion.value.active;
})

// methods
const open = () => {
    if (visible.value) {
        accordion.value.active = null;
    } else {
        accordion.value.active = index.value;
    }
}

const start = (el) => {
    el.style.height = el.scrollHeight + "px";
}

const end = (el) => {
    el.style.height = "";
}

onBeforeMount(() => {
    index.value = accordion.value.count++
})


</script>
<template>
    <li class="accordion__item my-auto">
      <div
        class="accordion__trigger"
        :class="{'accordion__trigger_active': visible}"
        @click="open">

        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
        <slot name="accordion-trigger"></slot>
      </div>

      <transition
        name="accordion"
        @enter="start"
        @after-enter="end"
        @before-leave="start"
        @after-leave="end">

        <div class="accordion__content"
          v-show="visible">
          <ul>
            <!-- This slot will handle all the content that is passed to the accordion -->
            <slot name="accordion-content"></slot>
          </ul>
        </div>
      </transition>
    </li>
</template>

<style>

.accordion__item {
  cursor: pointer;
  /* padding: 10px 20px 10px 3px; */
  /* border-bottom: 1px solid #ebebeb; */
  position: relative;
}

.accordion__trigger {
  display: flex;
  justify-content: space-between;
}

.accordion-enter-active,
.accordion-leave-active {
  will-change: height, opacity;
  transition: height 0.3s ease, opacity 0.3s ease;
  overflow: hidden;
}

.accordion-enter,
.accordion-leave-to {
  height: 0 !important;
  opacity: 0;
}

</style>
