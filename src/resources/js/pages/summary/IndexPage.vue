<template>
    <div class="m-4">
        <button type="button" class="btn btn-warning m-2" @click='$router.push({ name: "summary.comprehensive"})'>受注・施工・粗利高・総合集計</button>
        <button type="button" class="btn btn-success m-2" @click='$router.push({ name: "summary.order"})'>受注高集計</button>
        <button type="button" class="btn btn-success m-2" @click='$router.push({ name: "summary.profit"})'>施工・粗利高・集計</button>
    </div>
</template>
