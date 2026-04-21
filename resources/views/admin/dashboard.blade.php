@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="welcome-banner">
    <h1 style="margin: 0; font-size: 28px;">Welcome back, admin</h1>
    <p style="margin: 10px 0 0 0; opacity: 0.9;">Here's a live snapshot of your store, customers, and orders.</p>
    
    <div style="position: absolute; top: 30px; right: 30px; background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 15px; font-weight: 600;">
        Pending orders: 1
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <p>CATEGORIES</p>
        <h3>11</h3>
        <p>Manage your menu sections.</p>
    </div>
    <div class="stat-card">
        <p>PRODUCTS</p>
        <h3>22</h3>
        <p>Update dishes, pricing, and stock.</p>
    </div>
    <div class="stat-grid-item" style="grid-column: span 1;">
        <div class="stat-card">
            <p>ORDERS</p>
            <h3>1</h3>
            <p>Track every incoming order.</p>
        </div>
    </div>
    <div class="stat-card">
        <p>USERS</p>
        <h3>3</h3>
        <p>Manage customer access.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
    <div class="data-card">
        <div style="padding: 20px; border-bottom: 1px solid #f1f5f9; font-weight: 700;">Recent Orders</div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ORDER</th>
                    <th>CUSTOMER</th>
                    <th>STATUS</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1</td>
                    <td>Dhruv</td>
                    <td><span style="background: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">Pending</span></td>
                    <td style="font-weight: 700;">Rs 248.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="data-card" style="padding: 25px; display: flex; flex-direction: column; justify-content: center;">
        <p style="color: var(--text-muted); font-weight: bold; font-size: 12px; margin-bottom: 5px;">REVENUE</p>
        <h2 style="font-size: 32px; margin: 0; color: var(--text-dark);">Rs 248.00</h2>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 10px;">Calculated from all non-cancelled orders.</p>
    </div>
</div>
@endsection