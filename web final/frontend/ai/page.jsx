"use client";

import { useCallback, useState } from "react";
import { Bot, Sparkles } from "lucide-react";
import ChatBox from "../../components/ChatBox";
import SuggestionPanel from "../../components/SuggestionPanel";

export default function AIPage() {
  const [selectedPrompt, setSelectedPrompt] = useState("");

  const handleExternalPromptHandled = useCallback(() => {
    setSelectedPrompt("");
  }, []);

  return (
    <>
      <div className="ai-hero">
        <div className="container" style={{ display: "flex", alignItems: "center", gap: 16 }}>
          <div style={{ width: 52, height: 52, background: "rgba(29,191,115,0.2)", borderRadius: "50%", display: "flex", alignItems: "center", justifyContent: "center" }}>
            <Bot size={26} color="#1dbf73" />
          </div>
          <div>
            <h1 style={{ color: "white", fontSize: 28, fontWeight: 800, margin: 0 }}>LocalPro AI Assistant</h1>
            <p style={{ color: "#94a3b8", margin: "4px 0 0", display: "flex", alignItems: "center", gap: 6 }}>
              <Sparkles size={14} color="#3B82F6" /> Find services, compare workers, and get booking help instantly
            </p>
          </div>
        </div>
      </div>

      <div className="container ai-layout">
        <div>
          <ChatBox
            externalPrompt={selectedPrompt}
            onExternalPromptHandled={handleExternalPromptHandled}
          />
        </div>
        <SuggestionPanel onSelectPrompt={setSelectedPrompt} />
      </div>
    </>
  );
}
