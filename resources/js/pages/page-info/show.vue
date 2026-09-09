<script setup lang="ts">
import {storeToRefs} from "pinia";
import {computed, onMounted, ref, watch} from "vue";
import {usePageStore} from "@/modules/infoPage/stores/pageStore";
import {useRoute} from "vue-router";
import {PageBlockAccordionItem} from "@/modules/infoPage/components";
import {PageBlockSingle} from "@/modules/infoPage/components";
import {BaseLine, BaseSection} from "@/modules/app/components";

const pageStore = usePageStore();
const route = useRoute();
const {pageInfo} = storeToRefs(pageStore);

const openedBlockId = ref<number | string | null>(null);

const blocks = computed(() => {
    return pageInfo.value?.page?.blocks || [];
});

const fetchPageData = async (currentSlug: string) => {
    if (currentSlug) {
        await pageStore.getPageData(currentSlug);
    }
};

const toggleBlock = (id: number | string) => {
    openedBlockId.value = openedBlockId.value === id ? null : id;
};

onMounted(async () => {
    await fetchPageData(route.params.slug as string);
});

watch(
    () => route.params.slug,
    async (newSlug) => {
        await fetchPageData(newSlug as string);
        openedBlockId.value = null;
    }
);
</script>

<template>
    <BaseSection>
        <h1 class="heading-line">{{ pageInfo?.title }}</h1>
    </BaseSection>

    <BaseSection>
        <PageBlockSingle v-if="blocks.length <= 1" :blocks="blocks"/>

        <div v-else class="page-blocks">
            <template v-for="block in blocks" :key="block.id">
                <PageBlockAccordionItem
                    :block="block"
                    :is-opened="openedBlockId === block.id"
                    @toggle="toggleBlock(block.id)"
                />
                <BaseLine />
            </template>
        </div>
    </BaseSection>
</template>

<style scoped lang="scss">
.page-blocks {
    display: flex;
    flex-direction: column;
}
</style>
