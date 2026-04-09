import { lazy, Suspense } from "react";
import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
import "./App.css";

const SellerDashboardPage = lazy(() => import("./pages/SellerDashboardPage"));

function App() {
  return (
    <BrowserRouter>
      <Suspense fallback={<main className="seller-dashboard"><p>Loading dashboard...</p></main>}>
        <Routes>
          <Route path="/seller/dashboard" element={<SellerDashboardPage />} />
          <Route path="*" element={<Navigate to="/seller/dashboard" replace />} />
        </Routes>
      </Suspense>
    </BrowserRouter>
  );
}

export default App;
