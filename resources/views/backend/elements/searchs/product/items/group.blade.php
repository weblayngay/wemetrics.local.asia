<select class="form-control select2" name="group">
    <option value="">{{__('Nhóm giảm giá')}}</option>
    @include(VOUCHER_PARENT, ['parents' => $parents, 'parentId' => $parentId, 'sub' => VOUCHER_SUB, 'node' => $node, 'separate' => SEPARATE, 'verticalBar' => VERTICAL_BAR])
</select>