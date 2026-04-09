import { lazy, Suspense, useEffect, useMemo, useState } from "react";
import MetricCard from "../components/MetricCard";
import { getSellerMetrics, getSellerReport, loginSeller } from "../api/dashboard";
import { formatCurrency, formatDateInput } from "../lib/format";

const EarningsChart = lazy(() => import("../components/EarningsChart"));
const ReportTable = lazy(() => import("../components/ReportTable"));

const TOKEN_KEY = "sls_token";
const USER_KEY = "sls_user";

const DEMO_METRICS = {
  activeBookings: 4,
  completedBookings: 18,
  bookingsLast30Days: 26,
  earningsLast30Days: { gross: 1240, platformFee: 124, net: 1116 },
  lifetimeEarnings: { gross: 8420, platformFee: 842, net: 7578 }
};

const DEMO_ROWS = [
  {
    _id: "demo-1",
    createdAt: new Date().toISOString(),
    gigId: { title: "Deep Home Cleaning", category: "Cleaning" },
    amount: 120,
    platformFee: 12,
    netAmount: 108
  },
  {
    _id: "demo-2",
    createdAt: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(),
    gigId: { title: "Pipe Leakage Repair", category: "Plumbing" },
    amount: 90,
    platformFee: 9,
    netAmount: 81
  },
  {
    _id: "demo-3",
    createdAt: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(),
    gigId: { title: "Switchboard Installation", category: "Electrical" },
    amount: 160,
    platformFee: 16,
    netAmount: 144
  }
];

export default function SellerDashboardPage() {
  const [token, setToken] = useState(() => localStorage.getItem(TOKEN_KEY) || "");
  const [user, setUser] = useState(() => {
    const raw = localStorage.getItem(USER_KEY);
    return raw ? JSON.parse(raw) : null;
  });
  const [email, setEmail] = useState("seller@example.com");
  const [password, setPassword] = useState("Password123!");

  const [metrics, setMetrics] = useState(null);
  const [report, setReport] = useState({ totals: null, rows: [] });
  const [busy, setBusy] = useState(false);
  const [error, setError] = useState("");

  const [fromDate, setFromDate] = useState(() => formatDateInput(new Date(Date.now() - 29 * 24 * 60 * 60 * 1000)));
  const [toDate, setToDate] = useState(() => formatDateInput(new Date()));

  const isDemoMode = !token;

  useEffect(() => {
    if (!token) return;
    loadDashboard(token, fromDate, toDate);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [token]);

  async function handleLogin(event) {
    event.preventDefault();
    setBusy(true);
    setError("");

    try {
      const data = await loginSeller({ email, password });
      if (data?.user?.role !== "worker") {
        throw new Error("This dashboard is only for seller accounts (worker role).");
      }

      localStorage.setItem(TOKEN_KEY, data.token);
      localStorage.setItem(USER_KEY, JSON.stringify(data.user));
      setToken(data.token);
      setUser(data.user);
    } catch (e) {
      setError(e.message || "Login failed");
    } finally {
      setBusy(false);
    }
  }

  async function loadDashboard(authToken, from, to) {
    setBusy(true);
    setError("");

    try {
      const [metricsRes, reportRes] = await Promise.all([
        getSellerMetrics(authToken),
        getSellerReport(authToken, { from, to })
      ]);

      setMetrics(metricsRes.metrics);
      setReport({ totals: reportRes.totals, rows: reportRes.rows || [] });
    } catch (e) {
      setError(e.message || "Failed to load dashboard");
      if (String(e.message || "").toLowerCase().includes("unauthorized")) {
        handleLogout();
      }
    } finally {
      setBusy(false);
    }
  }

  async function handleGenerateReport(event) {
    event.preventDefault();
    if (!token) return;
    await loadDashboard(token, fromDate, toDate);
  }

  function handleLogout() {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
    setToken("");
    setUser(null);
    setMetrics(null);
    setReport({ totals: null, rows: [] });
  }

  const metricsData = isDemoMode ? DEMO_METRICS : metrics;
  const reportData = isDemoMode
    ? {
        totals: {
          totalRevenue: DEMO_ROWS.reduce((sum, row) => sum + row.amount, 0),
          platformFee: DEMO_ROWS.reduce((sum, row) => sum + row.platformFee, 0),
          netIncome: DEMO_ROWS.reduce((sum, row) => sum + row.netAmount, 0)
        },
        rows: DEMO_ROWS
      }
    : report;

  function downloadCsv() {
    const rows = reportData.rows || [];
    const totals = reportData.totals || { totalRevenue: 0, platformFee: 0, netIncome: 0 };

    const header = ["Date", "Service", "Category", "Gross", "Platform Fee", "Net"];
    const body = rows.map((item) => [
      new Date(item.createdAt).toISOString(),
      item.gigId?.title || "Service",
      item.gigId?.category || "",
      Number(item.amount || 0).toFixed(2),
      Number(item.platformFee || 0).toFixed(2),
      Number(item.netAmount || 0).toFixed(2)
    ]);

    body.push([]);
    body.push(["TOTAL", "", "", totals.totalRevenue.toFixed(2), totals.platformFee.toFixed(2), totals.netIncome.toFixed(2)]);

    const csv = [header, ...body]
      .map((line) => line.map((value) => `"${String(value).replace(/"/g, '""')}"`).join(","))
      .join("\n");

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `seller-report-${fromDate}-to-${toDate}.csv`;
    a.click();
    URL.revokeObjectURL(url);
  }

  const chartData = useMemo(() => {
    const map = new Map();
    (reportData.rows || []).forEach((item) => {
      const key = formatDateInput(item.createdAt);
      const previous = map.get(key) || 0;
      map.set(key, previous + Number(item.netAmount || 0));
    });

    return Array.from(map.entries())
      .sort(([a], [b]) => (a < b ? -1 : 1))
      .map(([day, net]) => ({ day: day.slice(5), net: Number(net.toFixed(2)) }));
  }, [reportData.rows]);

  const totals = reportData.totals || { totalRevenue: 0, platformFee: 0, netIncome: 0 };
  const earnings30 = metricsData?.earningsLast30Days || { gross: 0, platformFee: 0, net: 0 };

  return (
    <main className="seller-dashboard">
      <header className="topbar">
        <div className="brand">Beanix Seller</div>
        <nav>
          <a href="#overview">Dashboard</a>
          <a href="#report">Financial Report</a>
          {token ? (
            <button type="button" onClick={handleLogout}>Logout</button>
          ) : (
            <span className="demo-badge">Demo View</span>
          )}
        </nav>
      </header>

      <section className="hero-title" id="overview">
        <h2>Seller Dashboard</h2>
        <p>{token ? user?.email : "Preview mode: sign in for live data"}</p>
      </section>

      {!token && (
        <section className="panel login-inline-panel">
          <div className="panel-header">
            <h3>Sign In for Live Seller Data</h3>
          </div>
          <form onSubmit={handleLogin} className="filters inline-login-form">
            <label>
              Email
              <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
            </label>
            <label>
              Password
              <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
            </label>
            <button type="submit" disabled={busy}>{busy ? "Signing in..." : "Sign In"}</button>
          </form>
        </section>
      )}

      {error && <p className="error-banner">{error}</p>}

      <section className="metric-grid">
        <MetricCard icon="🧾" label="Active Bookings" value={metricsData?.activeBookings ?? 0} />
        <MetricCard icon="📅" label="Bookings Last 30 Days" value={metricsData?.bookingsLast30Days ?? 0} accent />
        <MetricCard icon="✅" label="Completed Bookings" value={metricsData?.completedBookings ?? 0} />
        <MetricCard icon="💵" label="Last 30 Days Gross" value={formatCurrency(earnings30.gross)} />
        <MetricCard icon="💳" label="Platform Fee (10%)" value={formatCurrency(earnings30.platformFee)} />
        <MetricCard icon="🏦" label="Last 30 Days Net" value={formatCurrency(earnings30.net)} accent />
      </section>

      <section className="panel totals-panel">
        <h3>All-Time Earnings Overview</h3>
        <div className="totals-row">
          <p>Total Revenue: <strong>{formatCurrency(totals.totalRevenue)}</strong></p>
          <p>Platform Fee (10%): <strong>{formatCurrency(totals.platformFee)}</strong></p>
          <p>Net Income: <strong>{formatCurrency(totals.netIncome)}</strong></p>
        </div>
      </section>

      <Suspense fallback={<section className="panel"><p>Loading chart...</p></section>}>
        <EarningsChart data={chartData} />
      </Suspense>

      <section className="panel" id="report">
        <div className="panel-header report-header">
          <h3>Financial Report</h3>
          <form className="filters" onSubmit={handleGenerateReport}>
            <label>
              From
              <input type="date" value={fromDate} onChange={(e) => setFromDate(e.target.value)} />
            </label>
            <label>
              To
              <input type="date" value={toDate} onChange={(e) => setToDate(e.target.value)} />
            </label>
            <button type="submit" disabled={busy || isDemoMode}>{busy ? "Loading..." : "Generate"}</button>
            <button type="button" className="secondary" onClick={downloadCsv} disabled={isDemoMode}>
              Download CSV
            </button>
          </form>
        </div>

        {isDemoMode && (
          <p className="demo-hint">Sign in to generate a real financial report and export CSV.</p>
        )}

        <div className="report-summary">
          <p>Total Revenue: <strong>{formatCurrency(totals.totalRevenue)}</strong></p>
          <p>Platform Fee Deducted (10%): <strong>{formatCurrency(totals.platformFee)}</strong></p>
          <p>Net Payout to Seller: <strong>{formatCurrency(totals.netIncome)}</strong></p>
        </div>

        <Suspense fallback={<p>Loading report table...</p>}>
          <ReportTable rows={reportData.rows || []} />
        </Suspense>
      </section>
    </main>
  );
}
