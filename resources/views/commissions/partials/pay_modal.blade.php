<!-- Modal Règlement Commissions par Commande -->
<div id="payCommissionModal" class="pay-modal-backdrop" style="display: none;">
    <div class="pay-modal-dialog">
        <form id="payCommissionForm" method="POST" action="">
            @csrf
            <!-- Modal Header -->
            <div class="pay-modal-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h3 class="pay-modal-title" style="margin: 0; color: #fff; font-size: 1.2rem; font-weight: 700;">
                            Règlement des Commissions par Commande
                        </h3>
                        <p style="margin: 2px 0 0 0; color: var(--text-secondary); font-size: 0.85rem;">
                            Collaborateur : <strong id="modalAgentName" style="color: #fff;">-</strong>
                            &bull; Solde total en attente : <strong id="modalAgentPendingTotal" style="color: #f59e0b;">0,00 DH</strong>
                        </p>
                    </div>
                </div>
                <button type="button" class="pay-modal-close-btn" onclick="closeCommissionModal()" title="Fermer la boîte">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="pay-modal-body">
                <!-- Filters and Quick Actions Bar -->
                <div class="pay-filter-bar">
                    <div style="display: flex; gap: 10px; align-items: center; flex: 1; flex-wrap: wrap;">
                        <!-- Status Filter -->
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <label for="modalFilterStatus" style="font-size: 0.82rem; color: var(--text-secondary); white-space: nowrap;">
                                <i class="fa-solid fa-filter" style="color: var(--primary);"></i> Statut commande :
                            </label>
                            <select id="modalFilterStatus" class="form-control" style="height: 36px; font-size: 0.85rem; min-width: 190px;">
                                <option value="all">Tous les statuts de commande</option>
                                <option value="delivered">Livrée</option>
                                <option value="shipped">Expédiée</option>
                                <option value="confirmed">Confirmée</option>
                                <option value="pending">En attente de paiement</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>

                        <!-- Search input -->
                        <div style="position: relative; flex: 1; min-width: 170px;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 11px; font-size: 0.8rem; color: var(--text-secondary);"></i>
                            <input type="text" id="modalSearch" class="form-control" placeholder="Rechercher code, client..." style="height: 36px; padding-left: 30px; font-size: 0.85rem;">
                        </div>
                    </div>

                    <!-- Selection Buttons -->
                    <div style="display: flex; gap: 6px;">
                        <button type="button" id="btnSelectAll" class="btn btn-secondary btn-sm" style="height: 36px; font-size: 0.8rem;">
                            <i class="fa-solid fa-check-double"></i> Tout cocher
                        </button>
                        <button type="button" id="btnDeselectAll" class="btn btn-secondary btn-sm" style="height: 36px; font-size: 0.8rem;">
                            <i class="fa-solid fa-xmark"></i> Tout décocher
                        </button>
                    </div>
                </div>

                <!-- Live Selection Metrics Strip -->
                <div class="pay-summary-strip">
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <div>
                            <span style="color: var(--text-secondary); font-size: 0.82rem;">Affichées :</span>
                            <strong id="statVisibleCount" style="color: #fff; font-size: 0.95rem;">0</strong>
                        </div>
                        <div style="height: 20px; width: 1px; background: rgba(255,255,255,0.1);"></div>
                        <div>
                            <span style="color: var(--text-secondary); font-size: 0.82rem;">Sélectionnées :</span>
                            <strong id="statSelectedCount" style="color: #38bdf8; font-size: 0.95rem;">0</strong>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: var(--text-secondary); font-size: 0.85rem;">Montant sélectionné :</span>
                        <strong id="statSelectedTotal" style="color: #10b981; font-size: 1.25rem;">0,00 DH</strong>
                    </div>
                </div>

                <!-- Orders Table Container -->
                <div class="pay-table-wrapper">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr style="position: sticky; top: 0; background: #0f172a; z-index: 2;">
                                <th style="width: 44px; text-align: center;">
                                    <input type="checkbox" id="modalMasterCheckbox" checked title="Cocher / Décocher les commandes affichées" style="cursor: pointer; width: 16px; height: 16px;">
                                </th>
                                <th>Commande</th>
                                <th>Statut Commande</th>
                                <th>Client</th>
                                <th>Date Vente</th>
                                <th style="text-align: right;">Total Commande</th>
                                <th style="text-align: right; color: #10b981;">Commission Due</th>
                            </tr>
                        </thead>
                        <tbody id="modalOrdersTbody">
                            <!-- Injected dynamically via JavaScript -->
                        </tbody>
                    </table>
                    <div id="modalEmptyState" style="display: none; padding: 2.5rem 1rem; text-align: center; color: var(--text-secondary);">
                        <i class="fa-solid fa-box-open" style="font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.5;"></i>
                        <p style="margin: 0; font-size: 0.95rem;">Aucune commande trouvée correspondant aux critères de filtre.</p>
                    </div>
                </div>

                <!-- Payment Details Inputs -->
                <div class="pay-details-grid">
                    <div>
                        <label style="display: block; font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 4px;">
                            <i class="fa-solid fa-calendar-day" style="color: var(--primary);"></i> Date de règlement :
                        </label>
                        <input type="date" name="paid_at" id="modalPaidAt" class="form-control" value="{{ date('Y-m-d') }}" style="height: 38px; font-size: 0.85rem;" required>
                    </div>
                    <div style="flex: 2;">
                        <label style="display: block; font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 4px;">
                            <i class="fa-solid fa-note-sticky" style="color: var(--primary);"></i> Mode / Note de règlement (optionnel) :
                        </label>
                        <input type="text" name="notes" id="modalNotes" class="form-control" placeholder="Ex: Règlement commissions par virement BMCE, espèces..." style="height: 38px; font-size: 0.85rem;">
                    </div>
                </div>

                <!-- Info Banner -->
                <div style="background: rgba(14, 165, 233, 0.08); border: 1px solid rgba(14, 165, 233, 0.2); border-radius: 8px; padding: 0.75rem 1rem; display: flex; align-items: center; gap: 10px; font-size: 0.82rem; color: #bae6fd;">
                    <i class="fa-solid fa-circle-info" style="font-size: 1rem; color: #38bdf8;"></i>
                    <span>Les commissions sélectionnées seront marquées comme <strong>Payées</strong> et enregistrées automatiquement dans la section <strong>Dépenses</strong>.</span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="pay-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeCommissionModal()" style="padding: 0.6rem 1.25rem;">
                    Annuler
                </button>
                <button type="submit" id="btnSubmitPayment" class="btn btn-success" style="padding: 0.6rem 1.5rem; font-weight: 600; font-size: 0.95rem;">
                    <i class="fa-solid fa-check"></i> Confirmer le paiement (<span id="btnSubmitAmount">0,00 DH</span>)
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ── Styles du Modal de Paiement ── */
.pay-modal-backdrop {
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.78);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    box-sizing: border-box;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

.pay-modal-backdrop.active {
    opacity: 1;
}

.pay-modal-dialog {
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    width: 100%;
    max-width: 880px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.9);
    transform: scale(0.95);
    transition: transform 0.2s ease-in-out;
    overflow: hidden;
}

.pay-modal-backdrop.active .pay-modal-dialog {
    transform: scale(1);
}

.pay-modal-dialog form {
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    margin: 0;
}

.pay-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    background: rgba(255, 255, 255, 0.02);
}

.pay-modal-close-btn {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    font-size: 1.8rem;
    line-height: 1;
    cursor: pointer;
    padding: 0 5px;
    border-radius: 6px;
    transition: color 0.15s ease, background 0.15s ease;
}

.pay-modal-close-btn:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
}

.pay-modal-body {
    padding: 1.25rem 1.5rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}

.pay-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    background: rgba(0, 0, 0, 0.25);
    padding: 0.85rem 1rem;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.06);
}

.pay-summary-strip {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    background: linear-gradient(90deg, rgba(16, 185, 129, 0.08), rgba(56, 189, 248, 0.08));
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 10px;
    padding: 0.75rem 1.25rem;
}

.pay-table-wrapper {
    background: rgba(0, 0, 0, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    max-height: 330px;
    overflow-y: auto;
}

.pay-table-wrapper::-webkit-scrollbar {
    width: 6px;
}
.pay-table-wrapper::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
}
.pay-table-wrapper::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 3px;
}

.pay-table-wrapper tr.row-item {
    cursor: pointer;
    transition: background 0.15s ease;
}
.pay-table-wrapper tr.row-item:hover {
    background: rgba(255, 255, 255, 0.04);
}
.pay-table-wrapper tr.row-item.selected {
    background: rgba(16, 185, 129, 0.06);
}

.pay-details-grid {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    background: rgba(0, 0, 0, 0.2);
    padding: 0.85rem 1rem;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.pay-modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    padding: 1.1rem 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    background: rgba(255, 255, 255, 0.02);
}
</style>

<script>
(function() {
    let currentCommissions = [];
    let currentAgentId = null;

    const statusLabels = {
        'pending': { label: 'En attente', class: 'badge-pending' },
        'confirmed': { label: 'Confirmée', class: 'badge-confirmed' },
        'shipped': { label: 'Expédiée', class: 'badge-shipped' },
        'delivered': { label: 'Livrée', class: 'badge-delivered' },
        'cancelled': { label: 'Annulée', class: 'badge-cancelled' }
    };

    function formatDH(num) {
        return (new Intl.NumberFormat('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(num || 0)) + ' DH';
    }

    // Open Modal function
    window.openPayCommissionModal = function(agentId, agentName, pendingTotal, commissions) {
        currentAgentId = agentId;
        currentCommissions = Array.isArray(commissions) ? commissions : [];

        const modal = document.getElementById('payCommissionModal');
        const form = document.getElementById('payCommissionForm');
        
        // Update Form Action
        form.action = "{{ url('commissions/agent') }}/" + agentId + "/pay-all";

        // Fill Header Info
        document.getElementById('modalAgentName').textContent = agentName;
        document.getElementById('modalAgentPendingTotal').textContent = formatDH(pendingTotal);

        // Reset Filter and Search
        document.getElementById('modalFilterStatus').value = 'all';
        document.getElementById('modalSearch').value = '';

        // Render Rows (all checked initially)
        renderOrdersTable();

        // Show Modal
        modal.style.display = 'flex';
        modal.offsetHeight; // trigger reflow
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeCommissionModal = function() {
        const modal = document.getElementById('payCommissionModal');
        if (!modal) return;
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 200);
    };

    // Close on click backdrop
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('payCommissionModal');
        if (e.target === modal) {
            closeCommissionModal();
        }
    });

    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('payCommissionModal');
            if (modal && modal.classList.contains('active')) {
                closeCommissionModal();
            }
        }
    });

    function renderOrdersTable() {
        const tbody = document.getElementById('modalOrdersTbody');
        const emptyState = document.getElementById('modalEmptyState');
        const statusFilter = document.getElementById('modalFilterStatus').value;
        const searchText = (document.getElementById('modalSearch').value || '').toLowerCase().trim();

        tbody.innerHTML = '';

        if (!currentCommissions || currentCommissions.length === 0) {
            emptyState.style.display = 'block';
            updateMetrics();
            return;
        }

        let visibleCount = 0;

        currentCommissions.forEach(comm => {
            const statusMatch = (statusFilter === 'all') || (comm.order_status === statusFilter);
            const searchMatch = !searchText || 
                (comm.order_code && comm.order_code.toLowerCase().includes(searchText)) ||
                (comm.customer_name && comm.customer_name.toLowerCase().includes(searchText));

            const isVisible = statusMatch && searchMatch;

            const tr = document.createElement('tr');
            tr.className = 'row-item' + (isVisible ? '' : ' d-none');
            tr.dataset.id = comm.id;
            tr.dataset.amount = comm.amount;
            tr.dataset.status = comm.order_status;
            tr.dataset.code = comm.order_code;
            tr.dataset.customer = comm.customer_name;
            if (!isVisible) {
                tr.style.display = 'none';
            } else {
                visibleCount++;
            }

            const statusObj = statusLabels[comm.order_status] || { label: comm.order_status, class: 'badge-pending' };
            const orderLink = comm.order_id ? `{{ url('orders') }}/${comm.order_id}` : '#';

            tr.innerHTML = `
                <td style="text-align: center; vertical-align: middle;">
                    <input type="checkbox" name="commission_ids[]" value="${comm.id}" class="comm-item-cb" checked style="cursor: pointer; width: 16px; height: 16px;">
                </td>
                <td style="font-weight: 600; vertical-align: middle;">
                    <a href="${orderLink}" target="_blank" style="color: var(--primary); text-decoration: none;" onclick="event.stopPropagation();">
                        ${comm.order_code} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                    </a>
                </td>
                <td style="vertical-align: middle;">
                    <span class="badge ${statusObj.class}" style="font-size: 0.75rem;">
                        ${statusObj.label}
                    </span>
                </td>
                <td style="vertical-align: middle; color: #fff;">
                    ${comm.customer_name || '-'}
                </td>
                <td style="vertical-align: middle; color: var(--text-secondary); font-size: 0.85rem;">
                    ${comm.order_date || '-'}
                </td>
                <td style="text-align: right; vertical-align: middle; color: var(--text-secondary); font-size: 0.9rem;">
                    ${formatDH(comm.order_total)}
                </td>
                <td style="text-align: right; vertical-align: middle; font-weight: 700; color: #10b981; font-size: 0.95rem;">
                    ${formatDH(comm.amount)}
                </td>
            `;

            // Toggle checkbox when clicking anywhere on the row
            tr.addEventListener('click', function(e) {
                if (e.target.tagName.toLowerCase() === 'a' || e.target.tagName.toLowerCase() === 'input') {
                    return;
                }
                const cb = tr.querySelector('.comm-item-cb');
                if (cb) {
                    cb.checked = !cb.checked;
                    updateRowClass(tr, cb.checked);
                    updateMetrics();
                }
            });

            const cb = tr.querySelector('.comm-item-cb');
            cb.addEventListener('change', function() {
                updateRowClass(tr, cb.checked);
                updateMetrics();
            });

            tbody.appendChild(tr);
            updateRowClass(tr, true);
        });

        if (visibleCount === 0) {
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }

        updateMetrics();
    }

    function updateRowClass(tr, isChecked) {
        if (isChecked) {
            tr.classList.add('selected');
        } else {
            tr.classList.remove('selected');
        }
    }

    function filterVisibleRows() {
        const statusFilter = document.getElementById('modalFilterStatus').value;
        const searchText = (document.getElementById('modalSearch').value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#modalOrdersTbody tr.row-item');
        let visibleCount = 0;

        rows.forEach(tr => {
            const status = tr.dataset.status;
            const code = (tr.dataset.code || '').toLowerCase();
            const customer = (tr.dataset.customer || '').toLowerCase();

            const statusMatch = (statusFilter === 'all') || (status === statusFilter);
            const searchMatch = !searchText || code.includes(searchText) || customer.includes(searchText);

            if (statusMatch && searchMatch) {
                tr.style.display = '';
                visibleCount++;
            } else {
                tr.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('modalEmptyState');
        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';

        updateMetrics();
    }

    function updateMetrics() {
        const rows = document.querySelectorAll('#modalOrdersTbody tr.row-item');
        let visibleCount = 0;
        let selectedCount = 0;
        let selectedTotal = 0;
        let allVisibleChecked = true;

        rows.forEach(tr => {
            const isVisible = tr.style.display !== 'none';
            if (isVisible) {
                visibleCount++;
                const cb = tr.querySelector('.comm-item-cb');
                if (cb && cb.checked) {
                    selectedCount++;
                    selectedTotal += parseFloat(tr.dataset.amount || 0);
                } else {
                    allVisibleChecked = false;
                }
            }
        });

        if (visibleCount === 0) {
            allVisibleChecked = false;
        }

        // Update displays
        document.getElementById('statVisibleCount').textContent = visibleCount;
        document.getElementById('statSelectedCount').textContent = selectedCount;
        document.getElementById('statSelectedTotal').textContent = formatDH(selectedTotal);
        document.getElementById('btnSubmitAmount').textContent = formatDH(selectedTotal);

        // Update Master Checkbox
        const masterCb = document.getElementById('modalMasterCheckbox');
        if (masterCb) {
            masterCb.checked = allVisibleChecked && visibleCount > 0;
        }

        // Submit Button State
        const submitBtn = document.getElementById('btnSubmitPayment');
        if (submitBtn) {
            submitBtn.disabled = (selectedCount === 0);
            if (selectedCount === 0) {
                submitBtn.style.opacity = '0.5';
                submitBtn.style.cursor = 'not-allowed';
            } else {
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        }
    }

    // Event Listeners for Filters
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('modalFilterStatus');
        const searchInput = document.getElementById('modalSearch');
        const btnSelectAll = document.getElementById('btnSelectAll');
        const btnDeselectAll = document.getElementById('btnDeselectAll');
        const masterCb = document.getElementById('modalMasterCheckbox');
        const payForm = document.getElementById('payCommissionForm');

        if (filterSelect) {
            filterSelect.addEventListener('change', filterVisibleRows);
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterVisibleRows);
        }

        if (btnSelectAll) {
            btnSelectAll.addEventListener('click', function() {
                const rows = document.querySelectorAll('#modalOrdersTbody tr.row-item');
                rows.forEach(tr => {
                    if (tr.style.display !== 'none') {
                        const cb = tr.querySelector('.comm-item-cb');
                        if (cb) {
                            cb.checked = true;
                            updateRowClass(tr, true);
                        }
                    }
                });
                updateMetrics();
            });
        }

        if (btnDeselectAll) {
            btnDeselectAll.addEventListener('click', function() {
                const rows = document.querySelectorAll('#modalOrdersTbody tr.row-item');
                rows.forEach(tr => {
                    if (tr.style.display !== 'none') {
                        const cb = tr.querySelector('.comm-item-cb');
                        if (cb) {
                            cb.checked = false;
                            updateRowClass(tr, false);
                        }
                    }
                });
                updateMetrics();
            });
        }

        if (masterCb) {
            masterCb.addEventListener('change', function() {
                const shouldCheck = masterCb.checked;
                const rows = document.querySelectorAll('#modalOrdersTbody tr.row-item');
                rows.forEach(tr => {
                    if (tr.style.display !== 'none') {
                        const cb = tr.querySelector('.comm-item-cb');
                        if (cb) {
                            cb.checked = shouldCheck;
                            updateRowClass(tr, shouldCheck);
                        }
                    }
                });
                updateMetrics();
            });
        }

        // Global delegate for clicking on .btn-open-pay-modal
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-open-pay-modal');
            if (btn) {
                e.preventDefault();
                const agentId = btn.dataset.agentId;
                const agentName = btn.dataset.agentName;
                const pendingTotal = parseFloat(btn.dataset.totalPending || 0);
                let commissions = [];
                try {
                    commissions = JSON.parse(btn.dataset.commissions || '[]');
                } catch(err) {
                    console.error('Error parsing commissions data:', err);
                }
                openPayCommissionModal(agentId, agentName, pendingTotal, commissions);
            }
        });

        // Form Submit confirmation
        if (payForm) {
            payForm.addEventListener('submit', function(e) {
                const selectedCbs = document.querySelectorAll('#modalOrdersTbody .comm-item-cb:checked');
                if (selectedCbs.length === 0) {
                    e.preventDefault();
                    alert('Veuillez cocher au moins une commande à régler.');
                    return false;
                }
            });
        }
    });
})();
</script>
