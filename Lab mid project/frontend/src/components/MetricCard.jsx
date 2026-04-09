export default function MetricCard({ icon, label, value, accent = false }) {
  return (
    <article className={`metric-card ${accent ? "metric-card-accent" : ""}`}>
      <div className="metric-icon" aria-hidden="true">{icon}</div>
      <p className="metric-value">{value}</p>
      <p className="metric-label">{label}</p>
    </article>
  );
}
