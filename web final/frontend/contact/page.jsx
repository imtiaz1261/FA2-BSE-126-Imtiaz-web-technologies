"use client";

export default function ContactPage() {
  return (
    <>
      <div className="page-header-dark animate-fade-down">
        <div className="container">
          <h1>Contact Us</h1>
          <p style={{ color: "#94a3b8" }}>We&apos;re here to help 24/7</p>
        </div>
      </div>
      <div className="container section">
        <div className="card reveal animate-scale-in" style={{ padding: 40, maxWidth: 480, margin: "0 auto" }}>
          <p style={{ color: "#475569", marginBottom: 24 }}>
            Need help? Reach us at{" "}
            <a href="mailto:support@localservices.com" style={{ color: "#1dbf73", fontWeight: 600 }}>
              support@localservices.com
            </a>
          </p>
          <form onSubmit={(e) => e.preventDefault()}>
            <div style={{ marginBottom: 16 }}>
              <input className="input" placeholder="Your name" />
            </div>
            <div style={{ marginBottom: 16 }}>
              <input className="input" type="email" placeholder="Your email" />
            </div>
            <div style={{ marginBottom: 20 }}>
              <textarea className="input" rows={4} placeholder="Your message" />
            </div>
            <button type="submit" className="btn-primary" style={{ width: "100%" }}>Send Message</button>
          </form>
        </div>
      </div>
    </>
  );
}
