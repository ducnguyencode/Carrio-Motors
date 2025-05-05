<?php

namespace App\Controllers;

use App\Services\InvoiceManager;

class InvoiceController
{
    private $invoiceManager;

    public function __construct(InvoiceManager $invoiceManager)
    {
        $this->invoiceManager = $invoiceManager;
    }

    public function showCheckoutForm()
    {
        $data = [
            'pageTitle' => 'Confirm Order',
        ];
    }

    public function processOrder()
    {
        $customerInfo = [
            'customer_name' => $_POST['customer_name'] ?? '',
            'customer_phone' => $_POST['customer_phone'] ?? '',
            'customer_email' => $_POST['customer_email'] ?? '',
            'payment_method' => $_POST['payment_method'] ?? 'Unspecified',
        ];

        $carItems = $_POST['items'] ?? [];

        $itemsForInvoice = $carItems;

        $newInvoiceId = $this->invoiceManager->createInvoice($customerInfo, $itemsForInvoice);

        if ($newInvoiceId) {
        } else {
        }
    }

    public function view(int $invoiceId)
    {
        $invoiceDetails = $this->invoiceManager->getInvoiceById($invoiceId);

        if ($invoiceDetails) {
        } else {
        }
    }

    public function index()
    {
        $invoiceList = $this->invoiceManager->listAllInvoices();

        $data = [
            'pageTitle' => 'Manage Invoices',
            'invoices' => $invoiceList
        ];
    }

    public function updateStatus()
    {
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $newStatus = $_POST['status'] ?? '';

        if ($invoiceId <= 0 || empty($newStatus)) {
            return;
        }

        $updateSuccess = $this->invoiceManager->updateInvoiceStatus($invoiceId, $newStatus);

        if ($updateSuccess) {
        } else {
        }
    }
}
