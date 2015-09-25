<table class="form-layout">
    <tbody>
        <tr>
            <td colspan="3">
                {$form.lineitems_join_type.label}<br />
                {$form.lineitems_join_type.html}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {$form.lineitems_label.label}<br />
                {$form.lineitems_label.html}
            </td>
        </tr>
        <tr>
            <td>
                <label>{ts}Unit Price{/ts}</label><br />
                {$form.lineitems_unit_price_from.label} {$form.lineitems_unit_price_from.html}
                {$form.lineitems_unit_price_to.label} {$form.lineitems_unit_price_to.html}
            </td>
            <td>
                {$form.lineitems_qty.label}<br />
                {$form.lineitems_qty.html}
            </td>
            <td>
                <label>{ts}Line Total{/ts}</label><br />
                {$form.lineitems_line_total_from.label} {$form.lineitems_line_total_from.html}
                {$form.lineitems_line_total_to.label} {$form.lineitems_line_total_to.html}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {$form.lineitems_financial_type_id.label}<br />
                {$form.lineitems_financial_type_id.html}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {$form.lineitems_ps_field_value_id.label}<br />
                {$form.lineitems_ps_field_value_id.html}
            </td>
        </tr>
    </tbody>
</table>