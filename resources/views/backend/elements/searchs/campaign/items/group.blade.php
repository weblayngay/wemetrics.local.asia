<select class="form-control select2" name="group">
    <option value="">{{__('Nhóm chiến dịch')}}</option>
    @include(CAMPAIGN_PARENT, ['parents' => $parents, 'parentId' => $parentId, 'sub' => CAMPAIGN_SUB, 'node' => $node, 'separate' => SEPARATE, 'verticalBar' => VERTICAL_BAR])
</select>