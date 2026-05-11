<script setup lang="ts">
const organizations = [
    {
        href: 'https://mon.gov.ua/ua',
        src: 'https://rada.info/upload/users_files/21431247/0e595c2e22459f86d27939e4f226d0ea.png',
        alt: 'Міністерство освіти і науки України',
        width: '250px',
        height: '76px',
    },
    {
        href: 'https://nz.ua/',
        src: 'https://rada.info/upload/users_files/21431247/d7e515be2b27c09dead855ab6cadd1b3.png',
        alt: 'Нові Знання',
        width: '250px',
        height: '162px',
    },
    {
        href: 'http://doncv.gov.ua/',
        src: 'https://rada.info/upload/users_files/21431075/ce2547d113d1b5dc79af22d52918e93d.png',
        alt: 'Департамент освіти і науки Чернівецької ОВА',
        width: '250px',
        height: '136px',
    },
    {
        href: 'https://lms.e-school.net.ua/',
        src: 'https://rada.info/upload/users_files/21431075/ec36608cc0c85db80644fb78a944195a.png',
        alt: 'Всеукраїнська школа онлайн',
        width: '250px',
        height: '45px',
    },
    {
        href: 'https://osvita.ua',
        src: 'https://lh5.googleusercontent.com/proxy/04rUNnZ82KQOA4GuMcGuKQzXdfpLKlCl7AdhIRQ51FP_PAb_JAtwl4gRnD8BRNgXSZZyxy7zOMPcDN93tc3rLPGFhMvMEZWZwrk-9DPAg2y5Uwg',
        alt: 'Освіта.ua',
        width: '250px',
        height: '76px',
    }
]
</script>

<template>
    <section class="organizations">
        <div class="hr"></div>
        <template v-for="organization in organizations" :key="organization.src">
            <a rel="nofollow" :href="organization.href" target="_blank">
                <img
                    loading="lazy"
                    :alt="organization.alt"
                    :src="organization.src"
                    :style="`width: ${organization.width}; height: ${organization.height};`">
            </a>
            <div class="hr"></div>
        </template>
    </section>
</template>

<style scoped lang="scss">
.organizations {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: $space-4;
    margin-top: $space-8;

    a {
        cursor: pointer;
        transition: 0.3s ease;

        &:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        img {
            @media (max-width: $breakpoint-md) {
                width: 90% !important;
                height: auto !important;
                margin: 0 auto;
            }
        }
    }

    .hr {
        height: 1px;
        width: 90%;
        background: $color-gray-200;

        @media (max-width: $breakpoint-md) {
            margin: $space-3 auto;
            background: $color-gray-300;
        }
    }
}
</style>
