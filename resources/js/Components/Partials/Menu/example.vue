<template>
    <div>
        <Accordion>
            <AccordionItem v-for="cat in category.children" :key="cat.id">
                <template #accordion-trigger>
                    <button
                        :class="cn(`flex items-center justify-between w-full group`, !cat.issuestemplates.length ? 'opacity-50 cursor-not-allowed' : '')"
                    >
                        <p class="text-sm">
                            {{ cat.title.charAt(0).toUpperCase() + cat.title.slice(1) }}
                        </p>
                        <DynamicHeroicon name="chevron-down" :size="4" class="icon wHover neutral-x-4" outline></DynamicHeroicon>
                    </button>
                </template>

                <template #accordion-content v-if="cat.issuestemplates.length">
                    <div class="flex flex-col w-full mt-2 space-y-3 text-sm text-neutral-400" v-if="cat.issuestemplates.length">
                        <p
                            v-for="issuetemplate in cat.issuestemplates"
                            :key="issuetemplate.id"
                            class="font-light cursor-pointer buttonSm buttonSecondary"
                            @click="childCreateIssue(issuetemplate, cat.type)"
                        >
                            {{ issuetemplate.title.charAt(0).toUpperCase() + issuetemplate.title.slice(1) }}
                        </p>
                    </div>
                </template>
            </AccordionItem>
        </Accordion>

    </div>
</template>

<script setup>

</script>

