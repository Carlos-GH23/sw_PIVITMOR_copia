import type { ChatMessage } from "../Interfaces";
import { ref } from "vue";

export const useChat = () => {
    const messages = ref<ChatMessage[]>([]);
    const isLoading = ref<boolean>(false);

    const getCookie = (name) => {
        const value = `; ${document.cookie}`
        const parts = value.split(`; ${name}=`)
        if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift())
    }

    const fetchStreamResponse = async (
        message: string,
        onChunk: (chunk: string) => void
    ) => {
        const response = await fetch(route("chatbot.process"), {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
            },
            body: JSON.stringify({ message }),
        });

        if (!response.body) throw new Error("Navegador no soporta streaming");
        if (!response.ok) throw new Error("Error en el servidor");

        const reader = response.body.getReader();
        const decoder = new TextDecoder("utf-8");

        while (true) {
            const { value, done } = await reader.read();
            if (done) break;

            const chunk = decoder.decode(value, { stream: true });
            onChunk(chunk);
        }
    };

    const onMessage = async (text: string) => {
        if (text.length === 0) return;
        isLoading.value = true;

        messages.value.push({
            id: new Date().getTime(),
            itsMine: true,
            message: text,
            isError: false,
        });

        const botId = Date.now() + 1;
        const botMessage = {
            id: botId,
            itsMine: false,
            message: "",
            isError: false,
        };

        messages.value.push(botMessage);
        const currentBotMessage = messages.value.find((m) => m.id === botId);

        try {
            await fetchStreamResponse(text, (chunk) => {
                if (currentBotMessage) {
                    currentBotMessage.message += chunk;
                }
            });
        } catch (error) {
            console.error(error);
            if (currentBotMessage) {
                currentBotMessage.message += "\n[Error de conexión]";
                currentBotMessage.isError = true;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return {
        // Properties
        messages,
        isLoading,
        // Methods
        onMessage,
    };
};
