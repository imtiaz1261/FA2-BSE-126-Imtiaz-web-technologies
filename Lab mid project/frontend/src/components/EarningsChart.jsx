import {
  Area,
  AreaChart,
  CartesianGrid,
  ResponsiveContainer,
  Tooltip,
  XAxis,
  YAxis
} from "recharts";

export default function EarningsChart({ data }) {
  return (
    <section className="panel chart-panel">
      <div className="panel-header">
        <h3>Earnings Trend (Last 30 Days)</h3>
      </div>
      <div className="chart-wrap">
        <ResponsiveContainer width="100%" height={280}>
          <AreaChart data={data} margin={{ top: 18, right: 12, left: 0, bottom: 0 }}>
            <defs>
              <linearGradient id="earningsGradient" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="#d7a86e" stopOpacity={0.8} />
                <stop offset="95%" stopColor="#d7a86e" stopOpacity={0.06} />
              </linearGradient>
            </defs>
            <CartesianGrid strokeDasharray="4 4" stroke="#3a3a3d" />
            <XAxis dataKey="day" stroke="#9d9ea2" />
            <YAxis stroke="#9d9ea2" />
            <Tooltip
              contentStyle={{ background: "#131416", border: "1px solid #38393d", borderRadius: 10 }}
              labelStyle={{ color: "#e8e8ea" }}
              formatter={(value) => [`$${Number(value).toFixed(2)}`, "Net Earning"]}
            />
            <Area
              type="monotone"
              dataKey="net"
              stroke="#d7a86e"
              strokeWidth={2.5}
              fill="url(#earningsGradient)"
            />
          </AreaChart>
        </ResponsiveContainer>
      </div>
    </section>
  );
}
