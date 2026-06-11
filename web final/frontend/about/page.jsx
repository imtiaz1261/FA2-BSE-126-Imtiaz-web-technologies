import Link from "next/link";

export default function AboutPage() {
  return (
    <>
      <div className="page-header-dark animate-fade-down">
        <div className="container">
          <h1>About Us</h1>
          <p style={{ color: "#94a3b8", maxWidth: 560 }}>
            Connecting communities with trusted local professionals since 2020.
          </p>
        </div>
      </div>
      <div className="container section">
        <div className="card reveal" style={{ padding: 40, maxWidth: 720, margin: "0 auto" }}>
          <p style={{ color: "#475569", lineHeight: 1.8, fontSize: 16, margin: "0 0 24px" }}>
            Local Services connects homeowners and businesses with verified local
            professionals. Our mission is to make booking trusted service providers
            fast, transparent, and reliable.
          </p>
          <Link href="/bookings/new" className="btn-primary">Get Started</Link>
        </div>
      </div>
    </>
  );
}
