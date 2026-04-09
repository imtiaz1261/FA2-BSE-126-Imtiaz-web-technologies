import { formatCurrency, formatDateTime } from "../lib/format";

export default function ReportTable({ rows }) {
  return (
    <div className="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Service</th>
            <th>Category</th>
            <th>Gross</th>
            <th>Platform Fee (10%)</th>
            <th>Net</th>
          </tr>
        </thead>
        <tbody>
          {rows.length === 0 ? (
            <tr>
              <td colSpan={6} className="empty-cell">No completed bookings in this period.</td>
            </tr>
          ) : (
            rows.map((item) => (
              <tr key={item._id}>
                <td>{formatDateTime(item.createdAt)}</td>
                <td>{item.gigId?.title || "Service"}</td>
                <td>{item.gigId?.category || "-"}</td>
                <td>{formatCurrency(item.amount)}</td>
                <td>{formatCurrency(item.platformFee)}</td>
                <td>{formatCurrency(item.netAmount)}</td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
}
