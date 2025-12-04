<template>
    <div v-if="article != null" class="alert alert--success notification-popup">
        Добавлена новая статья 
        <strong>
            <a :href="`/articles/${article.slug}`" class="notification-link">
                {{ article.title }}
            </a>
        </strong>
        <button @click="article = null" class="notification-close">&times;</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: null
        }
    },
    created() {
        window.Echo.channel('articles')
            .listen('NewArticleEvent', (data) => {
                console.log('Received article:', data);
                this.article = data.article;
                
                // Автоматически скрыть через 10 секунд
                setTimeout(() => {
                    this.article = null;
                }, 10000);
            });
    }
}
</script>

<style scoped>
.notification-popup {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
    padding: 1rem 2.5rem 1rem 1.5rem;
    background: rgba(39, 174, 96, 0.95);
    color: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;
}

.notification-link {
    color: white;
    text-decoration: underline;
    font-weight: 600;
}

.notification-link:hover {
    color: #f0f0f0;
}

.notification-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: transparent;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 24px;
    height: 24px;
}

.notification-close:hover {
    opacity: 0.7;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
