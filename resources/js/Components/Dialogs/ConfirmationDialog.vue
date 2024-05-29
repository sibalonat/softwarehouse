<template>
    <div class="w-full shadow-md bg-slate-50 flex flex-col p-4">
        <div class="w-2/3 mx-auto">
            <p class="font-semibold text-lg text-center w-full">
                Are you sure about the current operation?
            </p>
            <div class="flex justify-around mt-5">
                <slot name="close-button"></slot>
                <slot name="confirm-button"></slot>
            </div>
        </div>
    </div>
</template>

